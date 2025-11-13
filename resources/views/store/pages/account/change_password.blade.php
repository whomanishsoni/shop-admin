@extends('store.layouts.app')

@section('title', 'Change Password - Waseem Fashion Studio')

@section('content')
    <main class="main__content_wrapper">
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Change Password</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('profile') }}">My Profile</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Change Password</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="my__account--section section--padding">
            <div class="container">
                <p class="account__welcome--text">Hello, {{ ucfirst(strtolower(Auth::guard('customer')->user()->first_name)) }} {{ ucfirst(strtolower(Auth::guard('customer')->user()->last_name)) }}! Update your password below.</p>
                <div class="my__account--section__inner border-radius-10 d-flex">
                    <div class="account__left--sidebar">
                        <h2 class="account__content--title h3 mb-20">My Account</h2>
                        <ul class="account__menu">
                            <li class="account__menu--list {{ request()->routeIs('profile') ? 'active' : '' }}"><a
                                    href="{{ route('profile') }}" class="account__menu--link">My Profile</a></li>
                            <li class="account__menu--list {{ request()->routeIs('editProfile') ? 'active' : '' }}"><a
                                    href="{{ route('editProfile') }}" class="account__menu--link">Edit Profile</a></li>
                            <li class="account__menu--list {{ request()->routeIs('changePassword') ? 'active' : '' }}"><a
                                    href="{{ route('changePassword') }}" class="account__menu--link">Change Password</a></li>
                            <li class="account__menu--list {{ request()->routeIs('orders') ? 'active' : '' }}"><a
                                    href="{{ route('orders') }}" class="account__menu--link">My Order</a></li>
                            <li class="account__menu--list {{ request()->routeIs('wishlist') ? 'active' : '' }}"><a
                                    href="{{ route('wishlist') }}" class="account__menu--link">Wishlist</a></li>
                            <li class="account__menu--list {{ request()->routeIs('addresses') ? 'active' : '' }}"><a
                                    href="{{ route('addresses') }}" class="account__menu--link">Addresses</a></li>
                            <li class="account__menu--list {{ request()->routeIs('logout') ? 'active' : '' }}">
                                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <a href="{{ route('logout') }}" class="account__menu--link"
                                        onclick="this.closest('form').submit(); return false;">Log Out</a>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <div class="account__wrapper">
                        <div class="account__content">
                            <h2 class="account__content--title h3 mb-20">Change Password</h2>
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
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
                            <form action="{{ route('update_password') }}" method="POST">
                                @csrf
                                <div class="row account__table--area">
                                    <div class="col-12 mb-12">
                                        <div class="checkout__input--list">
                                            <label for="current_password">Current Password:</label>
                                            <input class="checkout__input--field border-radius-5 form-control"
                                                   id="current_password" name="current_password" type="password" required>
                                            @error('current_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 mb-12">
                                        <div class="checkout__input--list">
                                            <label for="new_password">New Password:</label>
                                            <input class="checkout__input--field border-radius-5 form-control"
                                                   id="new_password" name="new_password" type="password" required>
                                            <div id="password-strength" class="password-strength-text" style="margin-top: -10px; margin-bottom: 15px; font-size: 14px;"></div>
                                            @error('new_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 mb-12">
                                        <div class="checkout__input--list">
                                            <label for="new_password_confirmation">Confirm New Password:</label>
                                            <input class="checkout__input--field border-radius-5 form-control"
                                                   id="new_password_confirmation" name="new_password_confirmation" type="password" required>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-12">
                                        <div class="row">
                                            <div class="col-8 text-center">
                                                <button class="account__login--btn primary__btn" type="submit">Update Password</button>
                                            </div>
                                            <div class="col-4 text-center">
                                                <a href="{{ route('profile') }}" class="account__login--btn primary__btn">Cancel</a>
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
    <script>
        const passwordInput = document.getElementById('new_password');
        const strengthText = document.getElementById('password-strength');

        passwordInput.addEventListener('input', function () {
            const password = this.value;
            let strength = 'Weak';
            let color = '#ff4d4f'; // Red for weak

            if (password.length >= 8) {
                const hasUpperCase = /[A-Z]/.test(password);
                const hasLowerCase = /[a-z]/.test(password);
                const hasNumber = /\d/.test(password);
                const hasSpecialChar = /[@$!%*?&]/.test(password);

                const criteriaMet = [hasUpperCase, hasLowerCase, hasNumber, hasSpecialChar].filter(Boolean).length;

                if (criteriaMet === 4) {
                    strength = 'Strong';
                    color = '#52c41a'; // Green for strong
                } else if (criteriaMet >= 2) {
                    strength = 'Medium';
                    color = '#faad14'; // Yellow for medium
                }
            }

            strengthText.textContent = `Password Strength: ${strength}`;
            strengthText.style.color = color;
        });
    </script>
    <style>
        .password-strength-text {
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 15px;
        }
    </style>
@endpush
