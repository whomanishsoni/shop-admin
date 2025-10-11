@extends('store.layouts.app')

@section('title', 'Edit Profile - Vyuga')

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
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Edit Profile</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="my__account--section section--padding">
            <div class="container">
                <p class="account__welcome--text">Hello, {{ $profileData['first_name'] }} {{ $profileData['last_name'] }}! Welcome to your dashboard!</p>
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
                            <h2 class="account__content--title h3 mb-20">Edit Profile</h2>
                            <form action="{{ route('update_profile') }}" method="POST">
                                @csrf
                                <div class="row account__table--area">
                                    <div class="col-lg-6 col-12 mb-12">
                                        <div class="checkout__input--list">
                                            <label>First Name:</label>
                                            <input class="checkout__input--field border-radius-5 form-control" name="first_name" value="{{ old('first_name', $profileData['first_name']) }}" type="text" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12 mb-12">
                                        <div class="checkout__input--list">
                                            <label>Last Name:</label>
                                            <input class="checkout__input--field border-radius-5 form-control" name="last_name" value="{{ old('last_name', $profileData['last_name']) }}" type="text" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12 mb-12">
                                        <div class="checkout__input--list">
                                            <label>Email-Id:</label>
                                            <input class="checkout__input--field border-radius-5 form-control" name="email" value="{{ old('email', $profileData['email']) }}" type="email" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12 mb-12">
                                        <div class="checkout__input--list">
                                            <label>Contact No.:</label>
                                            <input class="checkout__input--field border-radius-5 form-control" name="contact_no" value="{{ old('contact_no', $profileData['contact_no']) }}" type="text">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12 mb-12">
                                        <div class="checkout__input--list">
                                            <label>Alternative Contact No.:</label>
                                            <input class="checkout__input--field border-radius-5 form-control" name="alternative_contact_no" value="{{ old('alternative_contact_no', $profileData['alternative_contact_no']) }}" type="text">
                                        </div>
                                    </div>
                                    <div class="col-12 mb-12">
                                        <div class="row">
                                            <div class="col-8 text-center">
                                                <button class="account__login--btn primary__btn" type="submit">Update Profile</button>
                                            </div>
                                            <div class="col-2 text-center">
                                                <a href="{{ route('profile') }}" class="account__login--btn primary__btn">Cancel</a>
                                            </div>
                                            <div class="col-2 text-center">
                                                <a href="{{ route('addresses') }}" class="account__login--btn primary__btn">Manage Addresses</a>
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
