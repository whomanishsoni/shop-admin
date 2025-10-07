<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingZone;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ShippingZoneController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $shippingZones = ShippingZone::with('shippingMethod')->select('*');
            return DataTables::of($shippingZones)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('shipping_method', function($row) {
                    return $row->shippingMethod ? $row->shippingMethod->name : 'N/A';
                })
                ->addColumn('rate', function($row) {
                    return '$'.number_format($row->rate, 2);
                })
                ->addColumn('status', function($row) {
                    return $row->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.shipping-zones.show', $row->id).'" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                        <a href="'.route('admin.shipping-zones.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.shipping-zones.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'status', 'action'])
                ->make(true);
        }
        return view('admin.shipping-zones.index');
    }

    public function create()
    {
        $shippingMethods = ShippingMethod::where('status', 1)->get();
        return view('admin.shipping-zones.create', compact('shippingMethods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'states' => 'nullable|array',
            'shipping_method_id' => 'required|exists:shipping_methods,id',
            'rate' => 'required|numeric|min:0',
            'status' => 'boolean'
        ]);

        if (isset($validated['states'])) {
            $validated['states'] = json_encode($validated['states']);
        }

        ShippingZone::create($validated);

        return redirect()->route('admin.shipping-zones.index')->with('success', 'Shipping Zone created successfully');
    }

    public function show(ShippingZone $shippingZone)
    {
        $shippingZone->load('shippingMethod');
        return view('admin.shipping-zones.show', compact('shippingZone'));
    }

    public function edit(ShippingZone $shippingZone)
    {
        $shippingMethods = ShippingMethod::where('status', 1)->get();
        return view('admin.shipping-zones.edit', compact('shippingZone', 'shippingMethods'));
    }

    public function update(Request $request, ShippingZone $shippingZone)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'states' => 'nullable|array',
            'shipping_method_id' => 'required|exists:shipping_methods,id',
            'rate' => 'required|numeric|min:0',
            'status' => 'boolean'
        ]);

        $validated['status'] = $request->has('status') ? true : false;

        if (isset($validated['states'])) {
            $validated['states'] = json_encode($validated['states']);
        }

        $shippingZone->update($validated);

        return redirect()->route('admin.shipping-zones.index')->with('success', 'Shipping Zone updated successfully');
    }

    public function destroy(ShippingZone $shippingZone)
    {
        $shippingZone->delete();
        return redirect()->route('admin.shipping-zones.index')->with('success', 'Shipping Zone deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        ShippingZone::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Shipping Zones deleted successfully']);
    }
}
