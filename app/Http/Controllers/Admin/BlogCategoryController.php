<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BlogCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $blogCategories = BlogCategory::select('*');
            return DataTables::of($blogCategories)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('status', function($row) {
                    return $row->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.blog-categories.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.blog-categories.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'status', 'action'])
                ->make(true);
        }
        return view('admin.blog-categories.index');
    }

    public function create()
    {
        return view('admin.blog-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_categories,slug',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1'
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($request->name);

        BlogCategory::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'status' => (int) $validated['status'], // Ensure status is cast to integer
        ]);

        return redirect()->route('admin.blog-categories.index')->with('success', 'Blog Category created successfully');
    }

    public function show(BlogCategory $blogCategory)
    {
        $blogCategory->load('blogPosts');
        return view('admin.blog-categories.show', compact('blogCategory'));
    }

    public function edit(BlogCategory $blogCategory)
    {
        return view('admin.blog-categories.edit', compact('blogCategory'));
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_categories,slug,'.$blogCategory->id,
            'description' => 'nullable|string',
            'status' => 'required|in:0,1'
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($request->name);

        $blogCategory->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'status' => (int) $validated['status'], // Ensure status is cast to integer
        ]);

        return redirect()->route('admin.blog-categories.index')->with('success', 'Blog Category updated successfully');
    }

    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();
        return redirect()->route('admin.blog-categories.index')->with('success', 'Blog Category deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        BlogCategory::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Blog Categories deleted successfully']);
    }
}
