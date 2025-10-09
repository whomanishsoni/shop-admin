@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Create Customer</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Customers</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-user-plus"></i> Add New Customer
            </div>
            <div class="card-body">
                <form action="{{ route('admin.customers.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_no">Contact Number</label>
                        <input type="text" name="contact_no" id="contact_no" class="form-control" value="{{ old('contact_no') }}">
                    </div>
                    <div class="form-group">
                        <label for="alternative_contact_no">Alternative Contact Number</label>
                        <input type="text" name="alternative_contact_no" id="alternative_contact_no" class="form-control" value="{{ old('alternative_contact_no') }}">
                    </div>
                    <div class="form-group">
                        <label for="home_address">Home Address</label>
                        <textarea name="home_address" id="home_address" class="form-control">{{ old('home_address') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="shipping_address">Shipping Address</label>
                        <textarea name="shipping_address" id="shipping_address" class="form-control">{{ old('shipping_address') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="office_address">Office Address</label>
                        <textarea name="office_address" id="office_address" class="form-control">{{ old('office_address') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" name="city" id="city" class="form-control" value="{{ old('city') }}">
                    </div>
                    <div class="form-group">
                        <label for="state">State</label>
                        <input type="text" name="state" id="state" class="form-control" value="{{ old('state') }}">
                    </div>
                    <div class="form-group">
                        <label for="pincode">Pincode</label>
                        <input type="text" name="pincode" id="pincode" class="form-control" value="{{ old('pincode') }}">
                    </div>
                    <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" name="country" id="country" class="form-control" value="{{ old('country') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Create Customer</button>
                </form>
            </div>
        </div>
    </div>
@endsection
