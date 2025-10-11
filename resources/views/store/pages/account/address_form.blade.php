@extends('store.layouts.app')

@section('title', '{{ $action }} Address - Vyuga')

@section('content')
    <main class="main__content_wrapper">
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Account</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('addresses') }}">Addresses</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">{{ $action }} Address</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="my__account--section section--padding">
            <div class="container">
                <p class="account__welcome--text">Hello, {{ Auth::guard('customer')->user()->first_name }} {{ Auth::guard('customer')->user()->last_name }}! Welcome to your dashboard!</p>
                <div class="my__account--section__inner border-radius-10 d-flex">
                    <div class="account__left--sidebar">
                        <h2 class="account__content--title h3 mb-20">My Account</h2>
                        <ul class="account__menu">
                            <li class="account__menu--list {{ request()->routeIs('profile') ? 'active' : '' }}"><a href="{{ route('profile') }}" class="account__menu--link">My Profile</a></li>
                            <li class="account__menu--list {{ request()->routeIs('editProfile') ? 'active' : '' }}"><a href="{{ route('editProfile') }}" class="account__menu--link">Edit Profile</a></li>
                            <li class="account__menu--list {{ request()->routeIs('orders') ? 'active' : '' }}"><a href="{{ route('orders') }}" class="account__menu--link">My Order</a></li>
                            <li class="account__menu--list {{ request()->routeIs('wishlist') ? 'active' : '' }}"><a href="{{ route('wishlist') }}" class="account__menu--link">Wishlist</a></li>
                            <li class="account__menu--list {{ request()->routeIs('addresses') ? 'active' : '' }}"><a href="{{ route('addresses') }}" class="account__menu--link">Addresses</a></li>
                            <li class="account__menu--list {{ request()->routeIs('logout') ? 'active' : '' }}">
                                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <a href="{{ route('logout') }}" class="account__menu--link" onclick="this.closest('form').submit(); return false;">Log Out</a>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <div class="account__wrapper">
                        <div class="account__content">
                            <h2 class="account__content--title h3 mb-20">{{ $action }} Address</h2>
                            <form action="{{ $action === 'Add' ? route('address.store') : route('address.update', ['id' => $address['id']]) }}" method="POST">
                                @csrf
                                @if ($action === 'Edit')
                                    @method('PUT')
                                @endif
                                <div class="row account__table--area">
                                    <div class="col-lg-6 col-12 mb-12">
                                        <div class="checkout__input--list">
                                            <label>Name:</label>
                                            <input class="checkout__input--field border-radius-5 form-control" name="name" value="{{ old('name', $address['name'] ?? (Auth::guard('customer')->user()->first_name . ' ' . Auth::guard('customer')->user()->last_name)) }}" type="text" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12 mb-12">
                                        <div class="checkout__input--list">
                                            <label>Address:</label>
                                            <textarea class="checkout__input--field border-radius-5 form-control" name="address" rows="2" required>{{ old('address', $address['address'] ?? '') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12 mb-12">
                                        <div class="checkout__input--list">
                                            <label>City:</label>
                                            <input class="checkout__input--field border-radius-5 form-control" name="city" value="{{ old('city', $address['city'] ?? '') }}" type="text">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12 mb-12">
                                        <div class="checkout__input--list checkout__input--select select">
                                            <label class="checkout__select--label" for="state">State:</label>
                                            <select class="checkout__input--select__field border-radius-5" id="state" name="state">
                                                <option value="">Select State</option>
                                                <option value="Andaman and Nicobar Islands" {{ old('state', $address['state'] ?? '') === 'Andaman and Nicobar Islands' ? 'selected' : '' }}>Andaman and Nicobar Islands</option>
                                                <option value="Andhra Pradesh" {{ old('state', $address['state'] ?? '') === 'Andhra Pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
                                                <option value="Arunachal Pradesh" {{ old('state', $address['state'] ?? '') === 'Arunachal Pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>
                                                <option value="Assam" {{ old('state', $address['state'] ?? '') === 'Assam' ? 'selected' : '' }}>Assam</option>
                                                <option value="Bihar" {{ old('state', $address['state'] ?? '') === 'Bihar' ? 'selected' : '' }}>Bihar</option>
                                                <option value="Chandigarh" {{ old('state', $address['state'] ?? '') === 'Chandigarh' ? 'selected' : '' }}>Chandigarh</option>
                                                <option value="Chhattisgarh" {{ old('state', $address['state'] ?? '') === 'Chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
                                                <option value="Dadra and Nagar Haveli and Daman and Diu" {{ old('state', $address['state'] ?? '') === 'Dadra and Nagar Haveli and Daman and Diu' ? 'selected' : '' }}>Dadra and Nagar Haveli and Daman and Diu</option>
                                                <option value="Delhi" {{ old('state', $address['state'] ?? '') === 'Delhi' ? 'selected' : '' }}>Delhi</option>
                                                <option value="Goa" {{ old('state', $address['state'] ?? '') === 'Goa' ? 'selected' : '' }}>Goa</option>
                                                <option value="Gujarat" {{ old('state', $address['state'] ?? '') === 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                                                <option value="Haryana" {{ old('state', $address['state'] ?? '') === 'Haryana' ? 'selected' : '' }}>Haryana</option>
                                                <option value="Himachal Pradesh" {{ old('state', $address['state'] ?? '') === 'Himachal Pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
                                                <option value="Jammu and Kashmir" {{ old('state', $address['state'] ?? '') === 'Jammu and Kashmir' ? 'selected' : '' }}>Jammu and Kashmir</option>
                                                <option value="Jharkhand" {{ old('state', $address['state'] ?? '') === 'Jharkhand' ? 'selected' : '' }}>Jharkhand</option>
                                                <option value="Karnataka" {{ old('state', $address['state'] ?? '') === 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                                                <option value="Kerala" {{ old('state', $address['state'] ?? '') === 'Kerala' ? 'selected' : '' }}>Kerala</option>
                                                <option value="Ladakh" {{ old('state', $address['state'] ?? '') === 'Ladakh' ? 'selected' : '' }}>Ladakh</option>
                                                <option value="Lakshadweep" {{ old('state', $address['state'] ?? '') === 'Lakshadweep' ? 'selected' : '' }}>Lakshadweep</option>
                                                <option value="Madhya Pradesh" {{ old('state', $address['state'] ?? '') === 'Madhya Pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
                                                <option value="Maharashtra" {{ old('state', $address['state'] ?? '') === 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                                                <option value="Manipur" {{ old('state', $address['state'] ?? '') === 'Manipur' ? 'selected' : '' }}>Manipur</option>
                                                <option value="Meghalaya" {{ old('state', $address['state'] ?? '') === 'Meghalaya' ? 'selected' : '' }}>Meghalaya</option>
                                                <option value="Mizoram" {{ old('state', $address['state'] ?? '') === 'Mizoram' ? 'selected' : '' }}>Mizoram</option>
                                                <option value="Nagaland" {{ old('state', $address['state'] ?? '') === 'Nagaland' ? 'selected' : '' }}>Nagaland</option>
                                                <option value="Odisha" {{ old('state', $address['state'] ?? '') === 'Odisha' ? 'selected' : '' }}>Odisha</option>
                                                <option value="Puducherry" {{ old('state', $address['state'] ?? '') === 'Puducherry' ? 'selected' : '' }}>Puducherry</option>
                                                <option value="Punjab" {{ old('state', $address['state'] ?? '') === 'Punjab' ? 'selected' : '' }}>Punjab</option>
                                                <option value="Rajasthan" {{ old('state', $address['state'] ?? '') === 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                                                <option value="Sikkim" {{ old('state', $address['state'] ?? '') === 'Sikkim' ? 'selected' : '' }}>Sikkim</option>
                                                <option value="Tamil Nadu" {{ old('state', $address['state'] ?? '') === 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu</option>
                                                <option value="Telangana" {{ old('state', $address['state'] ?? '') === 'Telangana' ? 'selected' : '' }}>Telangana</option>
                                                <option value="Tripura" {{ old('state', $address['state'] ?? '') === 'Tripura' ? 'selected' : '' }}>Tripura</option>
                                                <option value="Uttar Pradesh" {{ old('state', $address['state'] ?? '') === 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                                                <option value="Uttarakhand" {{ old('state', $address['state'] ?? '') === 'Uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>
                                                <option value="West Bengal" {{ old('state', $address['state'] ?? '') === 'West Bengal' ? 'selected' : '' }}>West Bengal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12 mb-12">
                                        <div class="checkout__input--list">
                                            <label>Pincode:</label>
                                            <input class="checkout__input--field border-radius-5 form-control" name="pincode" value="{{ old('pincode', $address['pincode'] ?? '') }}" type="text">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12 mb-12">
                                        <div class="checkout__input--list checkout__input--select select">
                                            <label class="checkout__select--label" for="country">Country:</label>
                                            <select class="checkout__input--select__field border-radius-5" id="country" name="country">
                                                <option value="India" {{ old('country', $address['country'] ?? '') === 'India' ? 'selected' : '' }}>India</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12 mb-12">
                                        <div class="checkout__input--list">
                                            <label>
                                                <input type="checkbox" name="is_default" value="1" {{ old('is_default', $address['is_default'] ?? false) ? 'checked' : '' }}>
                                                Set as default address
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-12">
                                        <div class="row">
                                            <div class="col-8 text-center">
                                                <button class="account__login--btn primary__btn" type="submit">{{ $action === 'Edit' ? 'Update Address' : 'Add Address' }}</button>
                                            </div>
                                            <div class="col-2 text-center">
                                                <a href="{{ route('addresses') }}" class="account__login--btn primary__btn">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    @include('store.partials.js')
@endpush
