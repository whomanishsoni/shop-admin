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
                                                <option value="Telangana" {{ old('state', $address['state'] ?? '') === 'Telangana' ? 'selected' : '' }}>Telangana</option>
                                                <option value="Andhra Pradesh" {{ old('state', $address['state'] ?? '') === 'Andhra Pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
                                                <option value="Delhi" {{ old('state', $address['state'] ?? '') === 'Delhi' ? 'selected' : '' }}>Delhi</option>
                                                <option value="Uttar Pradesh" {{ old('state', $address['state'] ?? '') === 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
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
                                                <option value="">Select Country</option>
                                                <option value="India" {{ old('country', $address['country'] ?? '') === 'India' ? 'selected' : '' }}>India</option>
                                                <option value="United States" {{ old('country', $address['country'] ?? '') === 'United States' ? 'selected' : '' }}>United States</option>
                                                <option value="Netherlands" {{ old('country', $address['country'] ?? '') === 'Netherlands' ? 'selected' : '' }}>Netherlands</option>
                                                <option value="Afghanistan" {{ old('country', $address['country'] ?? '') === 'Afghanistan' ? 'selected' : '' }}>Afghanistan</option>
                                                <option value="Albania" {{ old('country', $address['country'] ?? '') === 'Albania' ? 'selected' : '' }}>Albania</option>
                                                <option value="Antigua Barbuda" {{ old('country', $address['country'] ?? '') === 'Antigua Barbuda' ? 'selected' : '' }}>Antigua Barbuda</option>
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
                                        <button class="account__login--btn primary__btn" type="submit">{{ $action }} Address</button>
                                        <a href="{{ route('addresses') }}" class="account__login--btn primary__btn ml-10">Cancel</a>
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
