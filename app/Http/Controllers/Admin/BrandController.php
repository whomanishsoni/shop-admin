<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
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
            $brands = Brand::select('*');
            return DataTables::of($brands)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('image', function($row) {
                    return $row->image ? '<img src="/storage/'.$row->image.'" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #e9ecef; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">' : '<div style="width: 60px; height: 60px; border: 2px dashed #dee2e6; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d; font-size: 10px; font-weight: 500;">No Image</div>';
                })
                ->addColumn('status', function($row) {
                    return $row->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.brands.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.brands.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'image', 'status', 'action'])
                ->make(true);
        }
        return view('admin.brands.index');
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:brands',
                'slug' => 'required|string|max:255|unique:brands',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'status' => 'required|boolean'
            ]);

            if ($request->hasFile('image')) {
                $validated['image'] = $this->processImage($request->file('image'), 'brands');
            }

            Brand::create($validated);

            return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('Brand creation failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to create brand. Please try with a smaller image.']);
        }
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:brands,name,'.$brand->id,
                'slug' => 'required|string|max:255|unique:brands,slug,'.$brand->id,
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'remove_image' => 'nullable|boolean',
                'status' => 'required|boolean'
            ]);

            if ($request->has('remove_image') && $request->remove_image) {
                if ($brand->image) {
                    Storage::disk('public')->delete($brand->image);
                }
                $validated['image'] = null;
            } elseif ($request->hasFile('image')) {
                if ($brand->image) {
                    Storage::disk('public')->delete($brand->image);
                }
                $validated['image'] = $this->processImage($request->file('image'), 'brands');
            }

            $brand->update($validated);

            return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('Brand update failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update brand. Please try with a smaller image.']);
        }
    }

    public function destroy(Brand $brand)
    {
        // Delete image
        if ($brand->image) {
            Storage::disk('public')->delete($brand->image);
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        $brands = Brand::whereIn('id', $request->ids)->get();

        foreach ($brands as $brand) {
            // Delete image
            if ($brand->image) {
                Storage::disk('public')->delete($brand->image);
            }

            $brand->delete();
        }

        return response()->json(['success' => 'Brands deleted successfully']);
    }
}
