@extends('store.layouts.app')

@section('title', 'My Orders - Vyuga')

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
                                <li class="breadcrumb__content--menu__items"><span class="text-white">My Order</span></li>
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
                            <h2 class="account__content--title h3 mb-20">My Order History</h2>
                            <div class="account__table--area">
                                <table class="account__table">
                                    <thead class="account__table--header">
                                        <tr class="account__table--header__child text-center">
                                            <th class="account__table--header__child--items text-center">Order</th>
                                            <th class="account__table--header__child--items text-center">Date</th>
                                            <th class="account__table--header__child--items text-center">Payment Status</th>
                                            <th class="account__table--header__child--items text-center">Status</th>
                                            <th class="account__table--header__child--items text-center">Total</th>
                                            <th class="account__table--header__child--items text-center">Action</th>
                                            <th class="account__table--header__child--items text-center">Like</th>
                                        </tr>
                                    </thead>
                                    <tbody class="account__table--body mobile__none">
                                        @foreach ($orders as $order)
                                            <tr class="account__table--body__child text-center">
                                                <td class="account__table--body__child--items">{{ $order['order_number'] }}</td>
                                                <td class="account__table--body__child--items">{{ $order['date'] }}</td>
                                                <td class="account__table--body__child--items">{{ $order['payment_status'] }}</td>
                                                <td class="account__table--body__child--items">{{ $order['status'] }}</td>
                                                <td class="account__table--body__child--items">Rs.{{ number_format($order['total'], 2) }}</td>
                                                <td>
                                                    <a class="wishlist__cart--btn primary__btn" href="{{ route('order.invoice', $order['id']) }}"
                                                       @if($order['status'] !== 'Fulfilled') style="opacity:0.5" @endif>Invoice</a>
                                                </td>
                                                <td>
                                                    <button class="like-btn" data-order-id="{{ $order['id'] }}"
                                                            style="background:none;border:none;cursor:pointer;">
                                                        <span class="heart-icon" style="color: {{ $order['liked'] ? '#ff0000' : '#ccc' }};">&#9829;</span>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tbody class="account__table--body mobile__block">
                                        @foreach ($orders as $order)
                                            <tr class="account__table--body__child">
                                                <td class="account__table--body__child--items">
                                                    <strong>Order</strong>
                                                    <span>{{ $order['order_number'] }}</span>
                                                </td>
                                                <td class="account__table--body__child--items">
                                                    <strong>Date</strong>
                                                    <span>{{ $order['date'] }}</span>
                                                </td>
                                                <td class="account__table--body__child--items">
                                                    <strong>Payment Status</strong>
                                                    <span>{{ $order['payment_status'] }}</span>
                                                </td>
                                                <td class="account__table--body__child--items">
                                                    <strong>Status</strong>
                                                    <span>{{ $order['status'] }}</span>
                                                </td>
                                                <td class="account__table--body__child--items">
                                                    <strong>Total</strong>
                                                    <span>Rs.{{ number_format($order['total'], 2) }}</span>
                                                </td>
                                                <td class="account__table--body__child--items">
                                                    <strong>Like</strong>
                                                    <button class="like-btn" data-order-id="{{ $order['id'] }}"
                                                            style="background:none;border:none;cursor:pointer;">
                                                        <span class="heart-icon" style="color: {{ $order['liked'] ? '#ff0000' : '#ccc' }};">&#9829;</span>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
