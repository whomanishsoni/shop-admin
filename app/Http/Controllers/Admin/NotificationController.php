<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $notifications = Notification::with('user')->select('*');
            return DataTables::of($notifications)
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="select-item" value="'.$row->id.'">';
                })
                ->addColumn('user', function($row) {
                    return $row->user ? $row->user->name : 'N/A';
                })
                ->addColumn('read_status', function($row) {
                    return $row->read_at ? '<span class="badge bg-secondary">Read</span>' : '<span class="badge bg-primary">Unread</span>';
                })
                ->addColumn('action', function($row) {
                    return '
                        <a href="'.route('admin.notifications.show', $row->id).'" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                        <a href="'.route('admin.notifications.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="'.route('admin.notifications.destroy', $row->id).'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'read_status', 'action'])
                ->make(true);
        }
        return view('admin.notifications.index');
    }

    public function create()
    {
        $users = User::all();
        return view('admin.notifications.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'read_at' => 'nullable|date'
        ]);

        Notification::create($validated);

        return redirect()->route('admin.notifications.index')->with('success', 'Notification created successfully');
    }

    public function show(Notification $notification)
    {
        $notification->load('user');
        return view('admin.notifications.show', compact('notification'));
    }

    public function edit(Notification $notification)
    {
        $users = User::all();
        return view('admin.notifications.edit', compact('notification', 'users'));
    }

    public function update(Request $request, Notification $notification)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'read_at' => 'nullable|date'
        ]);

        $notification->update($validated);

        return redirect()->route('admin.notifications.index')->with('success', 'Notification updated successfully');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return redirect()->route('admin.notifications.index')->with('success', 'Notification deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        Notification::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => 'Notifications deleted successfully']);
    }
}
