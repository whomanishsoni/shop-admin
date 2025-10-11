@extends('store.layouts.app')

@section('title', 'Register - Vyuga')

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
                            <div class="account__login register enhanced-form">
                                <div class="account__login--header mb-20">
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
                                        <div class="account__login--remember position__relative mb-15">
                                            <input class="checkout__checkbox--input" id="check2" name="terms" type="checkbox" required>
                                            <span class="checkout__checkbox--checkmark"></span>
                                            <label class="checkout__checkbox--label login__remember--label" for="check2">
                                                I have read and agree to the terms &amp; conditions
                                            </label>
                                        </div>
                                        <button class="account__login--btn primary__btn mb-15" type="submit">Submit & Register</button>
                                        <p class="account__login--signup__text mt-15">Already have an account? <a href="{{ route('login') }}">Login now</a></p>
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

        .enhanced-form .account__login--remember {
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
