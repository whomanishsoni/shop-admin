<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductAttributeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $attributes = ProductAttribute::select('*');
            return DataTables::of($attributes)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('status', function($row) {
                    return $row->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.product-attributes.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.product-attributes.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'status', 'action'])
                ->make(true);
        }
        return view('admin.product-attributes.index');
    }

    public function create()
    {
        return view('admin.product-attributes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'values' => 'nullable|array',
            'values.*' => 'nullable|string|max:255',
            'status' => 'boolean'
        ]);

        $validated['display_name'] = $validated['display_name'] ?? $validated['name'];
        
        if (isset($validated['values'])) {
            $validated['values'] = json_encode(array_filter($validated['values']));
        }

        $validated['status'] = $request->has('status') ? true : false;

        ProductAttribute::create($validated);

        return redirect()->route('admin.product-attributes.index')->with('success', 'Product Attribute created successfully');
    }

    public function show(ProductAttribute $productAttribute)
    {
        return view('admin.product-attributes.show', compact('productAttribute'));
    }

    public function edit(ProductAttribute $productAttribute)
    {
        return view('admin.product-attributes.edit', compact('productAttribute'));
    }

    public function update(Request $request, ProductAttribute $productAttribute)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'values' => 'nullable|array',
            'values.*' => 'nullable|string|max:255',
            'status' => 'boolean'
        ]);

        $validated['display_name'] = $validated['display_name'] ?? $validated['name'];
        
        if (isset($validated['values'])) {
            $validated['values'] = json_encode(array_filter($validated['values']));
        }

        $validated['status'] = $request->has('status') ? true : false;

        $productAttribute->update($validated);

        return redirect()->route('admin.product-attributes.index')->with('success', 'Product Attribute updated successfully');
    }

    public function destroy(ProductAttribute $productAttribute)
    {
        $productAttribute->delete();
        return redirect()->route('admin.product-attributes.index')->with('success', 'Product Attribute deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        ProductAttribute::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Product Attributes deleted successfully']);
    }
}
