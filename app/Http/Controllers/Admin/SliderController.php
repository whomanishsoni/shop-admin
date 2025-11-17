<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller
{
    use ImageProcessable;

    public function __construct()
    {
        // Remove any file size restrictions - via Laravel config override
        if (function_exists('ini_set')) {
            ini_set('upload_max_filesize', '0'); // Unlimited
            ini_set('post_max_size', '0'); // Unlimited
            ini_set('memory_limit', '1024M');
            ini_set('max_execution_time', '300');
            ini_set('max_input_time', '300');
            ini_set('file_uploads', '1');
        }

        // Also try Laravel's config override (might work better)
        config(['filesystems.max_file_size' => 0]);
        config(['app.maximum_upload_size' => 0]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sliders = Slider::select('*');
            return DataTables::of($sliders)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('image', function($row) {
                    return $row->image ? '<img src="/storage/'.$row->image.'" width="80" style="border-radius: 5px;">' : 'No Image';
                })
                ->addColumn('title', function($row) {
                    return $row->title;
                })
                ->addColumn('status', function($row) {
                    return $row->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.sliders.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.sliders.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'image', 'title', 'status', 'action'])
                ->make(true);
        }
        return view('admin.sliders.index');
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
                'link' => 'nullable|url',
                'sort_order' => 'nullable|integer',
                'status' => 'required|in:0,1',
            ]);

            if ($request->hasFile('image')) {
                $validated['image'] = $this->processImage($request->file('image'), 'sliders');
            }

            Slider::create($validated);

            return redirect()->route('admin.sliders.index')->with('success', 'Slider created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('Slider creation failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to create slider. Please try again.']);
        }
    }

    public function show(Slider $slider)
    {
        return view('admin.sliders.show', compact('slider'));
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'link' => 'nullable|url',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:0,1',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->processImage($request->file('image'), 'sliders');
        }

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated successfully');
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        Slider::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Sliders deleted successfully']);
    }
}
