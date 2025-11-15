<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $videos = Video::select('*');
            return DataTables::of($videos)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('status', function($row) {
                    return $row->status == 'active' ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.videos.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.videos.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'status', 'action'])
                ->make(true);
        }
        return view('admin.videos.index');
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video_path' => 'required|string',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        Video::create($validated);

        return redirect()->route('admin.videos.index')->with('success', 'Video created successfully');
    }

    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video' => 'nullable|mimes:mp4,mov,avi,wmv|max:20480', // 20MB max
            'video_path' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Handle video upload
        if ($request->hasFile('video')) {
            // Delete old video
            if ($video->video_path) {
                \Storage::disk('public')->delete($video->video_path);
            }
            $validated['video_path'] = $request->file('video')->store('videos', 'public');
        } elseif ($request->has('video_path')) {
            // Handle chunked upload result
            if ($video->video_path) {
                \Storage::disk('public')->delete($video->video_path);
            }
            $validated['video_path'] = $request->video_path;
        }

        $video->update($validated);

        return redirect()->route('admin.videos.index')->with('success', 'Video updated successfully');
    }

    public function destroy(Video $video)
    {
        // Delete associated video file
        if ($video->video_path) {
            \Storage::disk('public')->delete($video->video_path);
        }

        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'Video deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        $videos = Video::whereIn('id', $request->ids)->get();

        foreach ($videos as $video) {
            // Delete associated video files
            if ($video->video_path) {
                \Storage::disk('public')->delete($video->video_path);
            }
        }

        Video::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Videos deleted successfully']);
    }

    public function uploadChunk(Request $request)
    {
        try {
            $request->validate([
                'chunk' => 'required|file|max:1024', // 1MB max per chunk (to work with 2MB PHP limit)
                'chunkIndex' => 'required|integer|min:0',
                'totalChunks' => 'required|integer|min:1',
                'fileName' => 'required|string|max:255',
                'uploadId' => 'required|string|max:100',
            ]);

            $uploadId = $request->uploadId;
            $chunkIndex = $request->chunkIndex;
            $totalChunks = $request->totalChunks;
            $fileName = $request->fileName;

            // Create temp directory for chunks
            $tempDir = storage_path('app/temp/' . $uploadId);
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            // Save chunk with proper naming
            $chunkFileName = str_pad($chunkIndex, 5, '0', STR_PAD_LEFT); // Ensure proper ordering
            $chunkPath = $tempDir . '/' . $chunkFileName;
            $request->file('chunk')->move($tempDir, $chunkFileName);

            // Verify chunk was saved
            if (!file_exists($chunkPath)) {
                throw new \Exception('Failed to save chunk file');
            }

            // Check if all chunks are uploaded (quick count)
            $uploadedChunks = count(scandir($tempDir)) - 2; // Subtract . and ..
            $allChunksUploaded = $uploadedChunks >= $totalChunks;

            return response()->json([
                'success' => true,
                'chunkIndex' => $chunkIndex,
                'uploadedChunks' => $uploadedChunks,
                'totalChunks' => $totalChunks,
                'allChunksUploaded' => $allChunksUploaded,
            ]);

        } catch (\Exception $e) {
            \Log::error('Chunk upload error: ' . $e->getMessage(), [
                'uploadId' => $request->uploadId ?? null,
                'chunkIndex' => $request->chunkIndex ?? null,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Chunk upload failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function mergeChunks(Request $request)
    {
        try {
            $request->validate([
                'uploadId' => 'required|string|max:100',
                'fileName' => 'required|string|max:255',
                'totalChunks' => 'required|integer|min:1',
            ]);

            $uploadId = $request->uploadId;
            $fileName = $request->fileName;
            $totalChunks = $request->totalChunks;

            $tempDir = storage_path('app/temp/' . $uploadId);

            if (!file_exists($tempDir)) {
                throw new \Exception('Upload directory not found');
            }

            $finalPath = 'videos/' . uniqid() . '_' . $fileName;
            $finalFile = storage_path('app/public/' . $finalPath);
            $finalDir = dirname($finalFile);

            if (!file_exists($finalDir)) {
                mkdir($finalDir, 0755, true);
            }

            // Merge chunks in correct order
            $output = fopen($finalFile, 'wb');

            for ($i = 0; $i < $totalChunks; $i++) {
                $chunkFileName = str_pad($i, 5, '0', STR_PAD_LEFT);
                $chunkPath = $tempDir . '/' . $chunkFileName;

                if (!file_exists($chunkPath)) {
                    fclose($output);
                    throw new \Exception("Chunk {$i} not found");
                }

                $input = fopen($chunkPath, 'rb');
                stream_copy_to_stream($input, $output);
                fclose($input);
            }

            fclose($output);

            // Verify final file size
            if (!file_exists($finalFile) || filesize($finalFile) === 0) {
                throw new \Exception('Final file creation failed');
            }

            // Clean up temp files
            $this->deleteDirectory($tempDir);

            return response()->json([
                'success' => true,
                'filePath' => $finalPath,
                'fileUrl' => asset('storage/' . $finalPath),
            ]);

        } catch (\Exception $e) {
            \Log::error('Chunk merge error: ' . $e->getMessage(), [
                'uploadId' => $request->uploadId ?? null,
                'fileName' => $request->fileName ?? null,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Merge failed: ' . $e->getMessage(),
            ], 500);
        }
    }



    private function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
    }
}
