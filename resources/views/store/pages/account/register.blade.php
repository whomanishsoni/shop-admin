@extends('store.layouts.app')

@section('title', 'Register - Vyuga')

@section('content')
    <main class="main__content_wrapper">
        <div class="login__section section--padding" style="border-top:1px solid #ccc;border-bottom:1px solid #ccc">
            <div class="container">
                <form action="{{ route('register.attempt') }}" method="POST">
                    @csrf
                    <div class="login__section--inner">
                        <div class="row row-cols-md-1 row-cols-1">
                            <div class="col">
                                <div class="account__login register">
                                    <div class="account__login--header mb-25">
                                        <h2 class="account__login--header__title h3 mb-10">Create an Account</h2>
                                        <p class="account__login--header__desc">Register here if you are a new customer</p>
                                    </div>
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
                                    <div class="account__login--inner">
                                        <input class="account__login--input" name="first_name" placeholder="First Name" type="text" value="{{ old('first_name') }}" required>
                                        <input class="account__login--input" name="last_name" placeholder="Last Name" type="text" value="{{ old('last_name') }}" required>
                                        <input class="account__login--input" name="email" placeholder="Email Address" type="email" value="{{ old('email') }}" required>
                                        <input class="account__login--input" name="password" placeholder="Password" type="password" required>
                                        <input class="account__login--input" name="password_confirmation" placeholder="Confirm Password" type="password" required>
                                        <input class="account__login--input" name="contact_no" placeholder="Contact Number" type="text" value="{{ old('contact_no') }}">
                                        <input class="account__login--input" name="alternative_contact_no" placeholder="Alternative Contact Number" type="text" value="{{ old('alternative_contact_no') }}">
                                        <textarea class="account__login--input" name="home_address" placeholder="Home Address">{{ old('home_address') }}</textarea>
                                        <textarea class="account__login--input" name="shipping_address" placeholder="Shipping Address">{{ old('shipping_address') }}</textarea>
                                        <textarea class="account__login--input" name="office_address" placeholder="Office Address">{{ old('office_address') }}</textarea>
                                        <input class="account__login--input" name="city" placeholder="City" type="text" value="{{ old('city') }}">
                                        <input class="account__login--input" name="state" placeholder="State" type="text" value="{{ old('state') }}">
                                        <input class="account__login--input" name="pincode" placeholder="Pincode" type="text" value="{{ old('pincode') }}">
                                        <input class="account__login--input" name="country" placeholder="Country" type="text" value="{{ old('country') }}">
                                        <div class="account__login--remember position__relative mb-15">
                                            <input class="checkout__checkbox--input" id="check2" type="checkbox" required>
                                            <span class="checkout__checkbox--checkmark"></span>
                                            <label class="checkout__checkbox--label login__remember--label" for="check2">
                                                I have read and agree to the terms & conditions
                                            </label>
                                        </div>
                                        <button class="account__login--btn primary__btn mb-10" type="submit">Submit & Register</button>
                                        <p class="account__login--signup__text">Already have an account? <a href="{{ route('login') }}">Login now</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    @include('store.partials.js')
@endpush
