<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TaxController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $taxes = Tax::select('*');
            return DataTables::of($taxes)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('rate', function($row) {
                    return $row->rate.'%';
                })
                ->addColumn('status', function($row) {
                    return $row->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.taxes.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.taxes.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'status', 'action'])
                ->make(true);
        }
        return view('admin.taxes.index');
    }

    public function create()
    {
        return view('admin.taxes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:percentage,fixed',
            'rate' => 'required|numeric|min:0|max:100',
            'state' => 'nullable|string|max:255',
            'status' => 'boolean'
        ]);

        Tax::create($validated);

        return redirect()->route('admin.taxes.index')->with('success', 'Tax created successfully');
    }

    public function show(Tax $tax)
    {
        return view('admin.taxes.show', compact('tax'));
    }

    public function edit(Tax $tax)
    {
        return view('admin.taxes.edit', compact('tax'));
    }

    public function update(Request $request, Tax $tax)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:percentage,fixed',
            'rate' => 'required|numeric|min:0|max:100',
            'state' => 'nullable|string|max:255',
            'status' => 'boolean'
        ]);

        $validated['status'] = $request->has('status') ? true : false;

        $tax->update($validated);

        return redirect()->route('admin.taxes.index')->with('success', 'Tax updated successfully');
    }

    public function destroy(Tax $tax)
    {
        $tax->delete();
        return redirect()->route('admin.taxes.index')->with('success', 'Tax deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        Tax::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Taxes deleted successfully']);
    }
}
