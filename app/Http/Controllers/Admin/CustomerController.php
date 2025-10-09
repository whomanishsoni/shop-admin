<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $customers = Customer::select('*');
            return DataTables::of($customers)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.customers.show', $row->id).'" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                        <a href="'.route('admin.customers.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.customers.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        }
        return view('admin.customers.index');
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|string|min:8|confirmed',
            'contact_no' => 'nullable|string|max:20',
            'alternative_contact_no' => 'nullable|string|max:20',
            'home_address' => 'nullable|string',
            'shipping_address' => 'nullable|string',
            'office_address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        Customer::create($validated);

        return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully');
    }

    public function show(Customer $customer)
    {
        $customer->load(['orders', 'reviews']);
        return view('admin.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,'.$customer->id,
            'password' => 'nullable|string|min:8|confirmed',
            'contact_no' => 'nullable|string|max:20',
            'alternative_contact_no' => 'nullable|string|max:20',
            'home_address' => 'nullable|string',
            'shipping_address' => 'nullable|string',
            'office_address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $customer->update($validated);

        return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        Customer::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Customers deleted successfully']);
    }

    public function orders(Customer $customer)
    {
        $orders = $customer->orders()->with(['items', 'customer'])->latest()->paginate(10);
        return view('admin.customers.orders', compact('customer', 'orders'));
    }
}
