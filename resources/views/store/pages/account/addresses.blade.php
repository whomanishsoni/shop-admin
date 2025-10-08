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
                            <h2 class="account__content--title mb-20">My Addresses</h2>
                            <a href="#"><button class="new__address--btn primary__btn mb-25" type="button">Add a new address</button></a>
                            @foreach ($addresses as $address)
                                <div class="account__details two">
                                    <h4 class="account__details--title">{{ $address['is_default'] ? 'Default' : 'Additional' }}</h4>
                                    <p class="account__details--desc">{{ $address['name'] }} <br> {{ $address['address'] }}</p>
                                    <div class="account__details--footer d-flex">
                                        <button class="account__details--footer__btn" type="button">Edit</button>
                                        <button class="account__details--footer__btn" type="button">Delete</button>
                                        <button class="like-btn" data-address-id="{{ $address['id'] }}"
                                                style="background:none;border:none;cursor:pointer;">
                                            <span class="heart-icon" style="color: {{ $address['liked'] ? '#ff0000' : '#ccc' }};">&#9829;</span>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
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
        document.querySelectorAll('.like-btn').forEach(button => {
            button.addEventListener('click', function() {
                const heart = this.querySelector('.heart-icon');
                const isLiked = heart.style.color === 'rgb(255, 0, 0)';
                heart.style.color = isLiked ? '#ccc' : '#ff0000';
            });
        });
    </script>
@endpush
