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
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $brands = Brand::select('*');
            return DataTables::of($brands)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('image', function($row) {
                    if ($row->image) {
                        return '<img src="'.asset('storage/'.$row->image).'" width="50" class="img-thumbnail">';
                    }
                    return 'No Image';
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
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands',
            'slug' => 'required|string|max:255|unique:brands',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('brands', 'public');
        }

        Brand::create($validated);

        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,'.$brand->id,
            'slug' => 'required|string|max:255|unique:brands,slug,'.$brand->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($brand->image) {
                Storage::disk('public')->delete($brand->image);
            }
            $validated['image'] = $request->file('image')->store('brands', 'public');
        }

        $brand->update($validated);

        return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully');
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
