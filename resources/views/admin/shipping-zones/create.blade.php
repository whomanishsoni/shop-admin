@extends('admin.layouts.app')

@section('title', 'Create Shipping Zone')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Create Shipping Zone</h1>
    <a href="{{ route('admin.shipping-zones.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to List
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Create Shipping Zone</h6>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.shipping-zones.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="states">States <span class="text-danger">*</span></label>
                <select class="form-control @error('states') is-invalid @enderror" id="states" name="states[]" multiple="multiple" style="width: 100%;">
                    @php
                        $indianStates = [
                            'AN' => 'Andaman and Nicobar Islands',
                            'AP' => 'Andhra Pradesh',
                            'AR' => 'Arunachal Pradesh',
                            'AS' => 'Assam',
                            'BR' => 'Bihar',
                            'CH' => 'Chandigarh',
                            'CT' => 'Chhattisgarh',
                            'DL' => 'Delhi',
                            'DN' => 'Dadra and Nagar Haveli and Daman and Diu',
                            'GA' => 'Goa',
                            'GJ' => 'Gujarat',
                            'HP' => 'Himachal Pradesh',
                            'HR' => 'Haryana',
                            'JH' => 'Jharkhand',
                            'JK' => 'Jammu and Kashmir',
                            'KA' => 'Karnataka',
                            'KL' => 'Kerala',
                            'LA' => 'Ladakh',
                            'LD' => 'Lakshadweep',
                            'MH' => 'Maharashtra',
                            'ML' => 'Meghalaya',
                            'MN' => 'Manipur',
                            'MP' => 'Madhya Pradesh',
                            'MZ' => 'Mizoram',
                            'NL' => 'Nagaland',
                            'OR' => 'Odisha',
                            'PB' => 'Punjab',
                            'PY' => 'Puducherry',
                            'RJ' => 'Rajasthan',
                            'SK' => 'Sikkim',
                            'TN' => 'Tamil Nadu',
                            'TG' => 'Telangana',
                            'TR' => 'Tripura',
                            'UP' => 'Uttar Pradesh',
                            'UT' => 'Uttarakhand',
                            'WB' => 'West Bengal',
                        ];
                    @endphp
                    @foreach($indianStates as $code => $name)
                        <option value="{{ $code }}" {{ in_array($code, old('states', [])) ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('states')
                    <div class="invalid-feedback">{{ $message }}</div>
                @endif
                @if ($errors->has('states'))
                    <div class="alert alert-danger mt-2">Please select at least one state.</div>
                @endif
            </div>

            <div class="form-group">
                <label for="shipping_method_id">Shipping Method <span class="text-danger">*</span></label>
                <select class="form-control @error('shipping_method_id') is-invalid @enderror" id="shipping_method_id" name="shipping_method_id" required>
                    <option value="">Select a Shipping Method</option>
                    @foreach($shippingMethods as $method)
                        <option value="{{ $method->id }}" {{ old('shipping_method_id') == $method->id ? 'selected' : '' }}>{{ $method->name }}</option>
                    @endforeach
                </select>
                @error('shipping_method_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="rate">Rate ($) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" class="form-control @error('rate') is-invalid @enderror" id="rate" name="rate" value="{{ old('rate') }}" required>
                @error('rate')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status <span class="text-danger">*</span></label>
                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', 1) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block">Create</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#states').select2({
        placeholder: "Select states",
        allowClear: true,
        width: '100%'
    });
});
</script>
@endpush
