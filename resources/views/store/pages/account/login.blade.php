@extends('store.layouts.app')

@section('title', 'Login - Vyuga')

@section('content')
    <main class="main__content_wrapper">
        <div class="login__section section--padding" style="border-top:1px solid #ccc;border-bottom:1px solid #ccc">
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
                <div class="login__section--inner">
                    <div class="row row-cols-md-2 row-cols-1">
                        <div class="col">
                            <div class="account__login">
                                <div class="account__login--header mb-25">
                                    <h2 class="account__login--header__title h3 mb-10">Login</h2>
                                    <p class="account__login--header__desc">Login if you are a returning customer.</p>
                                </div>
                                <form action="{{ route('login.attempt') }}" method="POST">
                                    @csrf
                                    <div class="account__login--inner">
                                        <input class="account__login--input" name="email" placeholder="Email Address" type="email" value="{{ old('email') }}" required>
                                        <input class="account__login--input" name="password" placeholder="Password" type="password" required>
                                        <div class="account__login--remember__forgot mb-15 d-flex justify-content-between align-items-center">
                                            <div class="account__login--remember position__relative">
                                                <input class="checkout__checkbox--input" id="check1" name="remember" type="checkbox">
                                                <span class="checkout__checkbox--checkmark"></span>
                                                <label class="checkout__checkbox--label login__remember--label" for="check1">
                                                    Remember me</label>
                                            </div>
                                            <a href="{{ route('forgot_password') }}" class="account__login--forgot">Forgot Your Password?</a>
                                        </div>
                                        <button class="account__login--btn primary__btn" type="submit">Login</button>
                                        <p class="account__login--signup__text">Don't Have an Account? <a href="{{ route('register') }}">Sign up now</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col">
                            <div class="account__login register">
                                <div class="account__login--header mb-25">
                                    <h2 class="account__login--header__title h3 mb-10">Create an Account</h2>
                                    <p class="account__login--header__desc">Register here if you are a new customer</p>
                                </div>
                                <form action="{{ route('register.attempt') }}" method="POST">
                                    @csrf
                                    <div class="account__login--inner">
                                        <input class="account__login--input" name="name" placeholder="Name" type="text" value="{{ old('name') }}" required>
                                        <input class="account__login--input" name="email" placeholder="Email Address" type="email" value="{{ old('email') }}" required>
                                        <input class="account__login--input" name="password" placeholder="Password" type="password" required>
                                        <input class="account__login--input" name="password_confirmation" placeholder="Confirm Password" type="password" required>
                                        <button class="account__login--btn primary__btn mb-10" type="submit">Submit &amp; Register</button>
                                        <div class="account__login--remember position__relative">
                                            <input class="checkout__checkbox--input" id="check2" name="terms" type="checkbox" required>
                                            <span class="checkout__checkbox--checkmark"></span>
                                            <label class="checkout__checkbox--label login__remember--label" for="check2">
                                                I have read and agree to the terms &amp; conditions</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    @include('store.partials.js')
@endpush
