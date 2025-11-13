<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $collections = Collection::select('*');
            return DataTables::of($collections)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('image', function($row) {
                    return $row->image ? '<img src="/storage/'.$row->image.'" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #e9ecef; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">' : '<div style="width: 60px; height: 60px; border: 2px dashed #dee2e6; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d; font-size: 10px; font-weight: 500;">No Image</div>';
                })
                ->addColumn('status', function($row) {
                    return $row->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('products_count', function($row) {
                    return $row->products()->count();
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.collections.show', $row->id).'" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                        <a href="'.route('admin.collections.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.collections.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'image', 'status', 'action'])
                ->make(true);
        }
        return view('admin.collections.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.collections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:collections,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        // Generate slug if not provided
        $validated['slug'] = $validated['slug'] ?? Str::slug($request->name);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('collections', 'public');
        }

        Collection::create($validated);

        return redirect()->route('admin.collections.index')->with('success', 'Collection created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Collection $collection)
    {
        $collection->load('products');
        return view('admin.collections.show', compact('collection'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Collection $collection)
    {
        return view('admin.collections.edit', compact('collection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Collection $collection)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:collections,slug,' . $collection->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'remove_image' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        // Generate slug if not provided
        $validated['slug'] = $validated['slug'] ?? Str::slug($request->name);

        // Handle image removal
        if ($request->has('remove_image') && $request->remove_image) {
            if ($collection->image && \Storage::disk('public')->exists($collection->image)) {
                \Storage::disk('public')->delete($collection->image);
            }
            $validated['image'] = null;
        } elseif ($request->hasFile('image')) {
            // Delete old image if exists
            if ($collection->image && \Storage::disk('public')->exists($collection->image)) {
                \Storage::disk('public')->delete($collection->image);
            }
            $validated['image'] = $request->file('image')->store('collections', 'public');
        }

        $collection->update($validated);

        return redirect()->route('admin.collections.index')->with('success', 'Collection updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collection $collection)
    {
        // Delete associated image
        if ($collection->image && \Storage::disk('public')->exists($collection->image)) {
            \Storage::disk('public')->delete($collection->image);
        }

        // Detach all products from this collection
        $collection->products()->detach();

        $collection->delete();

        return redirect()->route('admin.collections.index')->with('success', 'Collection deleted successfully');
    }

    /**
     * Bulk delete collections
     */
    public function bulkDelete(Request $request)
    {
        $collections = Collection::whereIn('id', $request->ids);
        foreach ($collections->get() as $collection) {
            // Delete associated image
            if ($collection->image && \Storage::disk('public')->exists($collection->image)) {
                \Storage::disk('public')->delete($collection->image);
            }
            // Detach all products
            $collection->products()->detach();
        }
        $collections->delete();
        return response()->json(['success' => 'Collections deleted successfully']);
    }
}
