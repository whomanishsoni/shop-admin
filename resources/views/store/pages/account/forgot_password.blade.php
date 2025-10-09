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
                    <div class="account__login">
                        <div class="account__login--header mb-25">
                            <h2 class="account__login--header__title h3 mb-10">Forgot Password</h2>
                            <p class="account__login--header__desc">Enter your email to reset your password.</p>
                        </div>
                        <form action="{{ route('forgot_password') }}" method="POST">
                            @csrf
                            <div class="account__login--inner">
                                <input class="account__login--input" name="email" placeholder="Email Address" type="email" value="{{ old('email') }}" required>
                                <button class="account__login--btn primary__btn" type="submit">Reset Password</button>
                                <p class="account__login--signup__text"><a href="{{ route('login') }}">Back to Login</a></p>
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
