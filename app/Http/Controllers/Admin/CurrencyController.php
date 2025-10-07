<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $currencies = Currency::select('*');
            return DataTables::of($currencies)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('is_default', function($row) {
                    return $row->is_default ? '<span class="badge bg-primary">Default</span>' : '';
                })
                ->addColumn('status', function($row) {
                    return $row->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.currencies.show', $row->id).'" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                        <a href="'.route('admin.currencies.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.currencies.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'is_default', 'status', 'action'])
                ->make(true);
        }
        return view('admin.currencies.index');
    }

    public function create()
    {
        return view('admin.currencies.create');
    }

    public function store(Request $request)
    {
        \Log::info('Store method called', $request->all());
        $validated = $request->validate([
            'code' => 'required|string|unique:currencies,code|max:10',
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0',
            'is_default' => 'boolean',
            'status' => 'boolean'
        ]);

        \Log::info('Validated data', $validated);

        if ($request->has('is_default') && $request->is_default) {
            \Log::info('Setting other currencies is_default to false');
            Currency::where('is_default', true)->update(['is_default' => false]);
        }

        $currency = Currency::create($validated);
        \Log::info('Currency created', ['id' => $currency->id]);

        return redirect()->route('admin.currencies.index')->with('success', 'Currency created successfully');
    }

    public function show(Currency $currency)
    {
        return view('admin.currencies.show', compact('currency'));
    }

    public function edit(Currency $currency)
    {
        return view('admin.currencies.edit', compact('currency'));
    }

    public function update(Request $request, Currency $currency)
    {
        \Log::info('Update method called', $request->all());
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:currencies,code,'.$currency->id,
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0',
            'is_default' => 'boolean',
            'status' => 'boolean'
        ]);

        \Log::info('Validated data', $validated);

        if ($request->has('is_default') && $validated['is_default']) {
            \Log::info('Setting other currencies is_default to false');
            Currency::where('is_default', true)->where('id', '!=', $currency->id)->update(['is_default' => false]);
        }

        $currency->update($validated);
        \Log::info('Currency updated', ['id' => $currency->id]);

        return redirect()->route('admin.currencies.index')->with('success', 'Currency updated successfully');
    }

    public function destroy(Currency $currency)
    {
        \Log::info('Deleting currency', ['id' => $currency->id]);
        $currency->delete();
        return redirect()->route('admin.currencies.index')->with('success', 'Currency deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        \Log::info('Bulk delete called', ['ids' => $request->ids]);
        Currency::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Currencies deleted successfully']);
    }
}
