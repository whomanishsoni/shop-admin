<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SubcategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $subcategories = Subcategory::with('category');

            return DataTables::of($subcategories)
                ->addColumn('checkbox', function ($subcategory) {
                    return '<input type="checkbox" class="select-checkbox" value="' . $subcategory->id . '">';
                })
                ->addColumn('image', function($row) {
                    return $row->image ? '<img src="/storage/'.$row->image.'" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #e9ecef; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">' : '<div style="width: 60px; height: 60px; border: 2px dashed #dee2e6; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d; font-size: 10px; font-weight: 500;">No Image</div>';
                })
                ->addColumn('category', function($row) {
                    return $row->category ? $row->category->name : 'N/A';
                })
                ->addColumn('status', function ($subcategory) {
                    return $subcategory->status
                        ? '<span class="badge badge-success">Active</span>'
                        : '<span class="badge badge-danger">Inactive</span>';
                })
                ->addColumn('action', function ($subcategory) {
                    return '<a href="' . route('admin.subcategories.edit', $subcategory->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="' . $subcategory->id . '"><i class="fas fa-trash"></button>';
                })
                ->rawColumns(['checkbox', 'image', 'status', 'action'])
                ->make(true);
        }

        return view('admin.subcategories.index');
    }

    public function create()
    {
        $categories = Category::where('status', true)->get();
        return view('admin.subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:subcategories,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer',
            'status' => 'boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('subcategories', 'public');
        }

        Subcategory::create($validated);

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory created successfully');
    }

    public function edit(Subcategory $subcategory)
    {
        $categories = Category::where('status', true)->get();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:subcategories,slug,' . $subcategory->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_image' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'status' => 'boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['status'] = $request->has('status') ? true : false;

        if ($request->has('remove_image') && $request->remove_image) {
            if ($subcategory->image) {
                Storage::disk('public')->delete($subcategory->image);
            }
            $validated['image'] = null;
        } elseif ($request->hasFile('image')) {
            if ($subcategory->image) {
                Storage::disk('public')->delete($subcategory->image);
            }
            $validated['image'] = $request->file('image')->store('subcategories', 'public');
        }

        $subcategory->update($validated);

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory updated successfully');
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        return response()->json(['success' => true, 'message' => 'Subcategory deleted successfully']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!empty($ids)) {
            Subcategory::whereIn('id', $ids)->delete();
            return response()->json(['success' => true, 'message' => 'Subcategories deleted successfully']);
        }

        return response()->json(['success' => false, 'message' => 'No subcategories selected']);
    }
}
