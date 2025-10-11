@extends('store.layouts.app')

@section('title', 'Forgot Password - Vyuga')

@section('content')
    <main class="main__content_wrapper">
        <section class="login__section section--padding" style="border-top:1px solid #ccc;border-bottom:1px solid #ccc">
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
                    <div class="account__login enhanced-form">
                        <div class="account__login--header mb-20">
                            <h2 class="account__login--header__title h3 mb-10">Forgot Password</h2>
                            <p class="account__login--header__desc">Enter your email to reset your password.</p>
                        </div>
                        <form action="{{ route('forgot_password') }}" method="POST">
                            @csrf
                            <div class="account__login--inner">
                                <input class="account__login--input" name="email" placeholder="Email Address" type="email" value="{{ old('email') }}" required>
                                <button class="account__login--btn primary__btn mb-15" type="submit">Reset Password</button>
                                <p class="account__login--signup__text mt-15"><a href="{{ route('login') }}">Back to Login</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
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

        .enhanced-form .account__login--signup__text {
            margin-top: 15px;
            text-align: center;
        }
    }
</style>
