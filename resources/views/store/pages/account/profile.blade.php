@extends('store.layouts.app')

@section('title', 'My Profile - Vyuga')

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
                                <li class="breadcrumb__content--menu__items"><span class="text-white">My Profile</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="my__account--section section--padding">
            <div class="container">
                <p class="account__welcome--text">Hello, Guest! Welcome to your dashboard!</p>
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
                            <h2 class="account__content--title h3 mb-20">My Profile</h2>
                            <div class="account__content">
                                <div class="row account__table--area">
                                    @foreach ($profileData as $data)
                                        <div class="col-lg-6 col-12 mb-12">
                                            <div class="checkout__input--list">
                                                <label>Name : </label>
                                                <input class="checkout__input--field border-radius-5 form-control" value="{{ $data['name'] }}" type="text" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-6 mb-12">
                                            <div class="checkout__input--list">
                                                <label>Email-Id : </label>
                                                <input class="checkout__input--field border-radius-5 form-control" value="{{ $data['email'] }}" type="text" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-12">
                                            <div class="checkout__input--list">
                                                <label>Contact No. : </label>
                                                <input class="checkout__input--field border-radius-5 form-control" value="{{ $data['contact_no'] }}" type="text" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12 mb-12">
                                            <div class="checkout__input--list">
                                                <label>Alt. Contact No. : </label>
                                                <input class="checkout__input--field border-radius-5 form-control" value="{{ $data['alt_contact_no'] }}" type="text" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-12 mb-12">
                                            <div class="checkout__input--list">
                                                <label>Address : </label>
                                                <textarea class="checkout__input--field border-radius-5 form-control" rows="1" type="text" readonly>{{ $data['address'] }}</textarea>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
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
