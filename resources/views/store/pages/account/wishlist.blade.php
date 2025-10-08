@extends('store.layouts.app')

@section('title', 'My Wishlist - Vyuga')

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
                                <li class="breadcrumb__content--menu__items"><span class="text-white">My Wishlist</span></li>
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
                            <h2 class="account__content--title h3 mb-20">My Wishlist</h2>
                            <div class="account__table--area">
                                <table class="cart__table--inner">
                                    <thead class="cart__table--header">
                                        <tr class="cart__table--header__items">
                                            <th class="cart__table--header__list">Product</th>
                                            <th class="cart__table--header__list">Price</th>
                                            <th class="cart__table--header__list text-center">Status</th>
                                            <th class="cart__table--header__list text-center">Action</th>
                                            <th class="cart__table--header__list text-center">Like</th>
                                        </tr>
                                    </thead>
                                    <tbody class="cart__table--body">
                                        @foreach ($wishlist as $item)
                                            <tr class="cart__table--body__items">
                                                <td class="cart__table--body__list">
                                                    <div class="cart__product d-flex align-items-center">
                                                        <button class="cart__remove--btn" aria-label="remove button" type="button" onclick="window.location.href='{{ route('wishlist.remove', $item['id']) }}'">
                                                            <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16px" height="16px"><path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z"/></svg>
                                                        </button>
                                                        <div class="cart__thumbnail">
                                                            <a href="{{ route('product.detail', $item['slug']) }}"><img class="border-radius-5" src="{{ $item['image'] }}" alt="cart-product"></a>
                                                        </div>
                                                        <div class="cart__content">
                                                            <h4 class="cart__content--title"><a href="{{ route('product.detail', $item['slug']) }}">{{ $item['name'] }}</a></h4>
                                                            <span class="cart__content--variant">COLOR: {{ $item['color'] }}</span>
                                                            <span class="cart__content--variant">{{ $item['size'] ? 'SIZE: ' . $item['size'] : 'WEIGHT: ' . $item['weight'] }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="cart__table--body__list">
                                                    <span class="cart__price">Rs. {{ number_format($item['price'], 2) }}</span>
                                                </td>
                                                <td class="cart__table--body__list text-center">
                                                    <span class="in__stock text__secondary">{{ $item['status'] }}</span>
                                                </td>
                                                <td class="cart__table--body__list text-right">
                                                    <a class="wishlist__cart--btn primary__btn" href="{{ $item['status'] === 'In-Stock' ? route('cart.add', $item['id']) : '#' }}">
                                                        {{ $item['status'] === 'In-Stock' ? 'Add To Cart' : 'Notify Me' }}
                                                    </a>
                                                </td>
                                                <td class="cart__table--body__list text-center">
                                                    <button class="like-btn" data-wishlist-id="{{ $item['id'] }}"
                                                            style="background:none;border:none;cursor:pointer;">
                                                        <span class="heart-icon" style="color: {{ $item['liked'] ? '#ff0000' : '#ccc' }};">&#9829;</span>
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
