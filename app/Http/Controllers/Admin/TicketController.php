<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tickets = Ticket::with('customer')->select('*');
            return DataTables::of($tickets)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('customer', function($row) {
                    return $row->customer ? $row->customer->name : 'N/A';
                })
                ->addColumn('priority', function($row) {
                    $badges = [
                        'low' => 'info',
                        'medium' => 'warning',
                        'high' => 'danger'
                    ];
                    $badge = $badges[$row->priority] ?? 'secondary';
                    return '<span class="badge bg-'.$badge.'">'.ucfirst($row->priority).'</span>';
                })
                ->addColumn('status', function($row) {
                    $badges = [
                        'open' => 'success',
                        'closed' => 'secondary',
                        'pending' => 'warning',
                        'resolved' => 'info'
                    ];
                    $badge = $badges[$row->status] ?? 'secondary';
                    return '<span class="badge bg-'.$badge.'">'.ucfirst($row->status).'</span>';
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.tickets.show', $row->id).'" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                        <a href="'.route('admin.tickets.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.tickets.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'priority', 'status', 'action'])
                ->make(true);
        }
        return view('admin.tickets.index');
    }

    public function create()
    {
        $customers = Customer::all();
        return view('admin.tickets.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'subject' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:open,closed,pending,resolved',
            'category' => 'nullable|string|max:255'
        ]);

        Ticket::create($validated);

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket created successfully');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load('customer');
        return view('admin.tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $customers = Customer::all();
        return view('admin.tickets.edit', compact('ticket', 'customers'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'subject' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:open,closed,pending,resolved',
            'category' => 'nullable|string|max:255'
        ]);

        $ticket->update($validated);

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket updated successfully');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('admin.tickets.index')->with('success', 'Ticket deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        Ticket::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Tickets deleted successfully']);
    }
}
