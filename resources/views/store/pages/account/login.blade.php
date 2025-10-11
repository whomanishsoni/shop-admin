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
                    <div class="row">
                        <div class="col">
                            <div class="account__login enhanced-form">
                                <div class="account__login--header mb-20">
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
                                                    Remember me
                                                </label>
                                            </div>
                                            <a href="{{ route('forgot_password') }}" class="account__login--forgot">Forgot Your Password?</a>
                                        </div>
                                        <button class="account__login--btn primary__btn mb-15" type="submit">Login</button>
                                        <p class="account__login--signup__text mt-15">Don't Have an Account? <a href="{{ route('register') }}">Sign up now</a></p>
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

<style>
    @media (min-width: 768px) {
        .enhanced-form {
            max-width: 550px;
            margin: 0 auto;
            padding: 30px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .enhanced-form .account__login--input {
            width: 100%;
            height: 50px;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .enhanced-form .account__login--btn {
            width: 100%;
            height: 55px;
            padding: 12px;
            font-size: 18px;
            line-height: 1.2;
            text-transform: none;
        }

        .enhanced-form .account__login--header {
            margin-bottom: 20px;
        }

        .enhanced-form .account__login--remember__forgot {
            margin-bottom: 15px;
        }

        .enhanced-form .account__login--signup__text {
            margin-top: 15px;
            text-align: center;
        }

        .enhanced-form .login__remember--label {
            line-height: 1.5;
        }
    }
</style>
