<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $subscribers = Subscriber::select('*');
            return DataTables::of($subscribers)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('status', function($row) {
                    return $row->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('subscribed_at', function($row) {
                    return $row->subscribed_at ? $row->subscribed_at->format('Y-m-d H:i') : 'N/A';
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.subscribers.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.subscribers.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'status', 'action'])
                ->make(true);
        }
        return view('admin.subscribers.index');
    }

    public function create()
    {
        return view('admin.subscribers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:subscribers,email',
            'status' => 'boolean',
            'subscribed_at' => 'nullable|date'
        ]);

        Subscriber::create($validated);

        return redirect()->route('admin.subscribers.index')->with('success', 'Subscriber created successfully');
    }

    public function show(Subscriber $subscriber)
    {
        return view('admin.subscribers.show', compact('subscriber'));
    }

    public function edit(Subscriber $subscriber)
    {
        return view('admin.subscribers.edit', compact('subscriber'));
    }

    public function update(Request $request, Subscriber $subscriber)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:subscribers,email,'.$subscriber->id,
            'status' => 'boolean',
            'subscribed_at' => 'nullable|date'
        ]);

        $validated['status'] = $request->has('status') ? true : false;

        $subscriber->update($validated);

        return redirect()->route('admin.subscribers.index')->with('success', 'Subscriber updated successfully');
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();
        return redirect()->route('admin.subscribers.index')->with('success', 'Subscriber deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        Subscriber::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Subscribers deleted successfully']);
    }
}
