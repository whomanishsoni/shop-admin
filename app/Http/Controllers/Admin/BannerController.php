<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller
{
    use ImageProcessable;

    public function __construct()
    {
        // Increase PHP limits for file uploads
        ini_set('upload_max_filesize', '5M');
        ini_set('post_max_size', '5M');
        ini_set('memory_limit', '512M');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $banners = Banner::select('*');
            return DataTables::of($banners)
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
                        <a href="'.route('admin.banners.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.banners.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'image', 'title', 'status', 'action'])
                ->make(true);
        }
        return view('admin.banners.index');
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'link' => 'nullable|url',
                'position' => 'nullable|string|max:255',
                'order' => 'nullable|integer',
                'status' => 'required|in:0,1'
            ]);

            if ($request->hasFile('image')) {
                $validated['image'] = $this->processImage($request->file('image'), 'banners');
            }

            Banner::create($validated);

            return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('Banner creation failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to create banner. Please try with a smaller image.']);
        }
    }

    public function show(Banner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'link' => 'nullable|url',
                'position' => 'nullable|string|max:255',
                'order' => 'nullable|integer',
                'status' => 'required|in:0,1'
            ]);

            if ($request->hasFile('image')) {
                $validated['image'] = $this->processImage($request->file('image'), 'banners');
            }

            $banner->update($validated);

            return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('Banner update failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update banner. Please try with a smaller image.']);
        }
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        Banner::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Banners deleted successfully']);
    }
}
