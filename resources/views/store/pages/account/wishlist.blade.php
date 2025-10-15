@extends('store.layouts.app')

@section('title', 'My Wishlist - Vyuga')

@section('content')
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
                        <li class="account__menu--list">
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
                                    </tr>
                                </thead>
                                <tbody class="cart__table--body">
                                    @if (empty($wishlistItems))
                                        <tr class="cart__table--body__items">
                                            <td colspan="4" class="text-center">Your wishlist is empty.</td>
                                        </tr>
                                    @else
                                        @foreach ($wishlistItems as $wishlistKey => $item)
                                            <tr class="cart__table--body__items" data-wishlist-key="{{ $wishlistKey }}">
                                                <td class="cart__table--body__list">
                                                    <div class="cart__product d-flex align-items-center">
                                                        <button class="cart__remove--btn" aria-label="remove button" type="button" data-wishlist-key="{{ $wishlistKey }}">
                                                            <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16px" height="16px">
                                                                <path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z"/>
                                                            </svg>
                                                        </button>
                                                        <div class="cart__thumbnail">
                                                            <a href="{{ route('product.detail', $item['slug']) }}"><img class="border-radius-5" src="{{ $item['image'] }}" alt="{{ $item['name'] }}"></a>
                                                        </div>
                                                        <div class="cart__content">
                                                            <h4 class="cart__content--title"><a href="{{ route('product.detail', $item['slug']) }}">{{ $item['name'] }}</a></h4>
                                                            @if (!empty($item['attributes']))
                                                                @foreach ($item['attributes'] as $key => $value)
                                                                    <span class="cart__content--variant">{{ strtoupper($key) }}: {{ $value }}</span>
                                                                @endforeach
                                                            @endif
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
                                                    <button class="wishlist__cart--btn primary__btn" data-wishlist-key="{{ $wishlistKey }}" {{ $item['status'] === 'In-Stock' ? '' : 'disabled' }}>
                                                        {{ $item['status'] === 'In-Stock' ? 'Add To Cart' : 'Notify Me' }}
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = '{{ csrf_token() }}';

    // Remove buttons
    document.querySelectorAll('.cart__remove--btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const wishlistKey = btn.getAttribute('data-wishlist-key');

            try {
                const response = await fetch('{{ route("wishlist.remove") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ wishlist_key: wishlistKey })
                });

                const data = await response.json();

                if (data.success) {
                    const row = btn.closest('tr');
                    row.remove();

                    const remainingRows = document.querySelectorAll('.cart__table--body tr.cart__table--body__items');
                    if (remainingRows.length === 0) {
                        document.querySelector('.cart__table--body').innerHTML = '<tr class="cart__table--body__items"><td colspan="4" class="text-center">Your wishlist is empty.</td></tr>';
                    }

                    // ✅ SHOW MESSAGE
                    showGlobalMessage(data.message, 'success');
                } else {
                    showGlobalMessage(data.message, 'error');
                }
            } catch (error) {
                showGlobalMessage('An error occurred while removing the item.', 'error');
            }
        });
    });

    // Add to cart buttons
    document.querySelectorAll('.wishlist__cart--btn').forEach(btn => {
        if (btn.disabled) return; // Skip disabled buttons

        btn.addEventListener('click', async () => {
            const wishlistKey = btn.getAttribute('data-wishlist-key');
            btn.disabled = true;
            btn.textContent = 'Moving...';

            try {
                const response = await fetch('{{ route("wishlist.moveToCart") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ wishlist_key: wishlistKey })
                });

                const data = await response.json();

                if (data.success) {
                    const row = btn.closest('tr');
                    row.remove();

                    const remainingRows = document.querySelectorAll('.cart__table--body tr.cart__table--body__items');
                    if (remainingRows.length === 0) {
                        document.querySelector('.cart__table--body').innerHTML = '<tr class="cart__table--body__items"><td colspan="4" class="text-center">Your wishlist is empty.</td></tr>';
                    }

                    // ✅ SHOW MESSAGE
                    showGlobalMessage(data.message, 'success');
                } else {
                    showGlobalMessage(data.message, 'error');
                }
            } catch (error) {
                showGlobalMessage('An error occurred while moving the item to the cart.', 'error');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Add To Cart';
            }
        });
    });
});
</script>
@endpush
