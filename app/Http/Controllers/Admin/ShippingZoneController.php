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
            try {
                $shippingZones = ShippingZone::with('shippingMethod')->select(['id', 'name', 'states', 'shipping_method_id', 'rate', 'status']);
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
->addColumn('states', function($row) {
    $rawStates = $row->getRawOriginal('states');
    $processedStates = $row->states;
    \Log::info('States debug for zone ID: ' . $row->id, [
        'raw' => $rawStates,
        'processed' => $processedStates,
    ]);
    if (is_array($processedStates) && !empty($processedStates)) {
        $indianStates = []; // Same as in the controller
        $mappedStates = array_map(fn($code) => $indianStates[strtoupper(trim($code))] ?? $code, $processedStates);
        if (empty($mappedStates) || count($mappedStates) !== count($processedStates)) {
            \Log::warning('Unmapped states for zone ID: ' . $row->id, ['states' => $processedStates]);
        }
        return implode(', ', array_filter($mappedStates));
    }
    \Log::warning('Invalid or empty states for zone ID: ' . $row->id, ['states' => $processedStates, 'raw' => $rawStates]);
    return 'N/A';
})
                    ->addColumn('status', function($row) {
                        return $row->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
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
            } catch (\Exception $e) {
                \Log::error('DataTables error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
                return response()->json(['error' => 'Server error occurred'], 500);
            }
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
            'states' => 'required|array|min:1',
            'states.*' => 'in:AN,AP,AR,AS,BR,CH,CT,DL,DN,GA,GJ,HP,HR,JH,JK,KA,KL,LA,LD,MH,ML,MN,MP,MZ,NL,OR,PB,PY,RJ,SK,TN,TG,TR,UP,UT,WB',
            'shipping_method_id' => 'required|exists:shipping_methods,id',
            'rate' => 'required|numeric|min:0',
            'status' => 'required|in:0,1',
        ]);

        \Log::info('Saving shipping zone:', ['states' => $validated['states']]);
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
            'states' => 'required|array|min:1',
            'states.*' => 'in:AN,AP,AR,AS,BR,CH,CT,DL,DN,GA,GJ,HP,HR,JH,JK,KA,KL,LA,LD,MH,ML,MN,MP,MZ,NL,OR,PB,PY,RJ,SK,TN,TG,TR,UP,UT,WB',
            'shipping_method_id' => 'required|exists:shipping_methods,id',
            'rate' => 'required|numeric|min:0',
            'status' => 'required|in:0,1',
        ]);

        $validated['status'] = (bool) $validated['status'];
        \Log::info('Updating shipping zone:', ['id' => $shippingZone->id, 'states' => $validated['states']]);
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
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:shipping_zones,id',
        ]);

        ShippingZone::whereIn('id', $validated['ids'])->delete();
        return response()->json(['success' => 'Shipping Zones deleted successfully']);
    }
}
