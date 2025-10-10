@extends('admin.layouts.app')

@section('title', 'View Ticket')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">View Ticket</h1>
    <div>
        <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Details</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Customer:</strong>
                    <p class="mb-0">{{ $ticket->customer ? $ticket->customer->name : 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Subject:</strong>
                    <p class="mb-0">{{ $ticket->subject ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Message:</strong>
                    <p class="mb-0">{{ $ticket->message ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Priority:</strong>
                    <p class="mb-0">
                        <span class="badge bg-{{ $ticket->priority == 'low' ? 'info' : ($ticket->priority == 'medium' ? 'warning' : ($ticket->priority == 'high' ? 'danger' : 'secondary')) }}">
                            {{ ucfirst($ticket->priority ?? 'N/A') }}
                        </span>
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Status:</strong>
                    <p class="mb-0">
                        <span class="badge bg-{{ $ticket->status == 'open' ? 'success' : ($ticket->status == 'pending' ? 'warning' : ($ticket->status == 'resolved' ? 'info' : ($ticket->status == 'closed' ? 'secondary' : 'secondary'))) }}">
                            {{ ucfirst($ticket->status ?? 'N/A') }}
                        </span>
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Category:</strong>
                    <p class="mb-0">{{ $ticket->category ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Created:</strong>
                    <p class="mb-0">{{ $ticket->created_at->format('M d, Y h:i A') }}</p>
                </div>

                <div class="mb-3">
                    <strong>Last Updated:</strong>
                    <p class="mb-0">{{ $ticket->updated_at->format('M d, Y h:i A') }}</p>
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
                <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="btn btn-warning btn-block w-100 mb-2">
                    <i class="fas fa-edit"></i> Edit
                </a>

                <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this item?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block w-100">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
