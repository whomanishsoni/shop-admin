@extends('store.layouts.app')

@section('title', 'My Addresses - Vyuga')

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
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Addresses</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="my__account--section section--padding">
            <div class="container">
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
                            <h2 class="account__content--title mb-20">My Addresses</h2>
                            <a href="{{ route('address.create') }}"><button class="new__address--btn primary__btn mb-25" type="button">Add a new address</button></a>
                            @if (empty($addresses))
                                <p>No addresses found.</p>
                            @else
                                @foreach ($addresses as $address)
                                    <div class="account__details two">
                                        <h4 class="account__details--title">{{ $address['is_default'] ? 'Default' : 'Additional' }}</h4>
                                        <p class="account__details--desc">
                                            {{ $address['name'] }} <br>
                                            {{ $address['address'] }} <br>
                                            @if ($address['city']) {{ $address['city'] . ',' }} @endif
                                            @if ($address['state']) {{ $address['state'] . ',' }} @endif
                                            @if ($address['pincode']) {{ $address['pincode'] . ',' }} @endif
                                            @if ($address['country']) {{ $address['country'] }} @endif
                                        </p>
                                        <div class="account__details--footer d-flex">
                                            <a href="{{ route('address.edit', ['id' => $address['id']]) }}" class="account__details--footer__btn">Edit</a>
                                            <form action="{{ route('address.delete', ['id' => $address['id']]) }}" method="POST" style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="account__details--footer__btn" onclick="return confirm('Are you sure you want to delete this address?')">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
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
