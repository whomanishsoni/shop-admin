@extends('admin.layouts.app')

@section('title', 'View Notification')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">View Notification</h1>
    <div>
        <a href="{{ route('admin.notifications.edit', $notification->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $notification->title }}</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Type:</strong>
                    <p class="mb-0">{{ $notification->type }}</p>
                </div>

                <div class="mb-3">
                    <strong>User:</strong>
                    <p class="mb-0">{{ $notification->user->name ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Message:</strong>
                    <div class="mb-0">
                        {!! nl2br(e($notification->message)) !!}
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Status:</strong>
                    <p class="mb-0">
                        <span class="badge bg-{{ $notification->read_at ? 'secondary' : 'primary' }}">
                            {{ $notification->read_at ? 'Read' : 'Unread' }}
                        </span>
                    </p>
                </div>

                @if($notification->read_at)
                <div class="mb-3">
                    <strong>Read At:</strong>
                    <p class="mb-0">{{ $notification->read_at->format('M d, Y h:i A') }}</p>
                </div>
                @endif

                <div class="mb-3">
                    <strong>Created:</strong>
                    <p class="mb-0">{{ $notification->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.notifications.edit', $notification->id) }}" class="btn btn-warning btn-block w-100 mb-2">
                    <i class="fas fa-edit"></i> Edit Notification
                </a>
                
                <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this notification?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block w-100">
                        <i class="fas fa-trash"></i> Delete Notification
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
