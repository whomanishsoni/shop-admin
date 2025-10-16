@extends('store.layouts.app')

@section('title', 'Shopping Cart - Vyuga')

@section('content')
    <section class="breadcrumb__section breadcrumb__bg" style="background: url({{ asset('assets/images/cart-banner.jpg') }});">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">Shopping Cart</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb__content--menu__items"><span class="text-white">Cart</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="cart__section section--padding">
        <div class="container-fluid">
            <div class="cart__section--inner">
                <form id="cart-form" action="{{ route('cart.update') }}" method="POST">
                    @csrf
                    <h2 class="cart__title mb-40">Shopping Cart</h2>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="cart__table">
                                <table class="cart__table--inner">
                                    <thead class="cart__table--header">
                                        <tr class="cart__table--header__items">
                                            <th class="cart__table--header__list">Product</th>
                                            <th class="cart__table--header__list">Price</th>
                                            <th class="cart__table--header__list">Quantity</th>
                                            <th class="cart__table--header__list">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="cart__table--body">
                                        @if (empty($cartItems))
                                            <tr class="cart__table--body__items">
                                                <td colspan="4" class="text-center">Your cart is empty.</td>
                                            </tr>
                                        @else
                                            @foreach ($cartItems as $cartKey => $item)
                                                <tr class="cart__table--body__items" data-cart-key="{{ $cartKey }}">
                                                    <td class="cart__table--body__list">
                                                        <div class="cart__product d-flex align-items-center">
                                                            <button class="cart__remove--btn" aria-label="remove item" type="button" data-cart-key="{{ $cartKey }}">
                                                                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16px" height="16px">
                                                                    <path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z"></path>
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
                                                        <span class="cart__price">Rs.{{ number_format($item['price'], 2) }}</span>
                                                    </td>
                                                    <td class="cart__table--body__list">
                                                        <div class="quantity__box">
                                                            <button type="button" class="quantity__value quickview__value--quantity decrease" aria-label="quantity value" value="Decrease Value">-</button>
                                                            <label>
                                                                <input type="number" class="quantity__number quickview__value--number" name="quantity[{{ $cartKey }}]" value="{{ $item['quantity'] }}" min="1" data-counter="" readonly>
                                                            </label>
                                                            <button type="button" class="quantity__value quickview__value--quantity increase" aria-label="quantity value" value="Increase Value">+</button>
                                                        </div>
                                                    </td>
                                                    <td class="cart__table--body__list">
                                                        <span class="cart__price end" data-total="{{ $item['total'] }}">Rs.{{ number_format($item['total'], 2) }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div class="continue__shopping d-flex justify-content-between">
                                    <a class="continue__shopping--link" href="{{ route('shop') }}">Continue shopping</a>
                                    <button class="continue__shopping--clear" type="button">Clear Cart</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="cart__summary border-radius-10">
                                <div class="coupon__code mb-30">
                                    <h3 class="coupon__code--title">Coupon</h3>
                                    <p class="coupon__code--desc">Enter your coupon code if you have one.</p>
                                    <div class="coupon__code--field d-flex">
                                        <label>
                                            <input class="coupon__code--field__input border-radius-5" placeholder="Coupon code" type="text">
                                        </label>
                                        <button class="coupon__code--field__btn primary__btn" type="submit">Apply Coupon</button>
                                    </div>
                                </div>
                                <div class="cart__note mb-20">
                                    <h3 class="cart__note--title">Note</h3>
                                    <p class="cart__note--desc">Add special instructions for your seller...</p>
                                    <textarea class="cart__note--textarea border-radius-5"></textarea>
                                </div>
                                <div class="cart__summary--total mb-20">
                                    <table class="cart__summary--total__table">
                                        <tbody>
                                            <tr class="cart__summary--total__list">
                                                <td class="cart__summary--total__title text-left">SUBTOTAL</td>
                                                <td class="cart__summary--amount text-right subtotal-amount">Rs.{{ number_format($subtotal, 2) }}</td>
                                            </tr>
                                            <tr class="cart__summary--total__list">
                                                <td class="cart__summary--total__title text-left">Shipping Fee</td>
                                                <td class="cart__summary--amount text-right shipping-amount">Rs.{{ number_format($shipping, 2) }}</td>
                                            </tr>
                                            <tr class="cart__summary--total__list">
                                                <td class="cart__summary--total__title text-left">Tax(18%)</td>
                                                <td class="cart__summary--amount text-right tax-amount">Rs.{{ number_format($tax, 2) }}</td>
                                            </tr>
                                            <tr class="cart__summary--total__list">
                                                <td class="cart__summary--total__title text-left"><strong>GRAND TOTAL</strong></td>
                                                <td class="cart__summary--amount text-right grand-amount"><strong>Rs.{{ number_format($grandTotal, 2) }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="cart__summary--footer">
                                    <p class="cart__summary--footer__desc">Shipping & taxes calculated at checkout</p>
                                    <div class="text-center">
                                        <a class="primary__btn checkout w-100" href="{{ route('checkout') }}">Proceed To Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = '{{ csrf_token() }}';

    // Quantity buttons
    document.querySelectorAll('.quantity__box').forEach(box => {
        const input = box.querySelector('.quantity__number');
        const decreaseBtn = box.querySelector('.decrease');
        const increaseBtn = box.querySelector('.increase');
        const cartKey = input.name.replace('quantity[', '').replace(']', '');

        decreaseBtn.addEventListener('click', async () => {
            let value = parseInt(input.value);
            if (value > 1) {
                input.value = value - 1;
                await updateQuantity(cartKey, input.value, input);
            }
        });

        increaseBtn.addEventListener('click', async () => {
            let value = parseInt(input.value);
            input.value = value + 1;
            await updateQuantity(cartKey, input.value, input);
        });
    });

    async function updateQuantity(cartKey, quantity, input) {
        const originalValue = parseInt(input.getAttribute('data-original') || input.value);
        input.disabled = true;

        try {
            const response = await fetch('{{ route("cart.update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ cart_key: cartKey, quantity: parseInt(quantity) })
            });

            const data = await response.json();

            if (data.success) {
                const row = input.closest('tr');
                const totalSpan = row.querySelector('.cart__price.end');
                totalSpan.textContent = `Rs.${data.itemTotal}`;
                totalSpan.setAttribute('data-total', data.itemTotal);
                updateTotals(data);
                showGlobalMessage(data.message, 'success');
            } else {
                input.value = data.oldQuantity || originalValue;
                showGlobalMessage(data.message, 'error');
            }
        } catch (error) {
            input.value = originalValue;
            showGlobalMessage('An error occurred while updating the cart.', 'error');
        } finally {
            input.disabled = false;
        }
    }

    // Remove buttons
    document.querySelectorAll('.cart__remove--btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const cartKey = btn.getAttribute('data-cart-key');
            btn.disabled = true;

            try {
                const response = await fetch('{{ route("cart.remove") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ cart_key: cartKey })
                });

                const data = await response.json();

                if (data.success) {
                    const row = btn.closest('tr');
                    row.remove();
                    updateTotals(data);

                    const remainingRows = document.querySelectorAll('.cart__table--body tr.cart__table--body__items');
                    if (remainingRows.length === 0) {
                        document.querySelector('.cart__table--body').innerHTML = '<tr class="cart__table--body__items"><td colspan="4" class="text-center">Your cart is empty.</td></tr>';
                    }

                    showGlobalMessage(data.message, 'success');
                } else {
                    showGlobalMessage(data.message, 'error');
                }
            } catch (error) {
                showGlobalMessage('An error occurred while removing the item.', 'error');
            } finally {
                btn.disabled = false;
            }
        });
    });

    // ✅ FIXED CLEAR CART - NO ALERT!
    document.querySelectorAll('.continue__shopping--clear').forEach(btn => {
        btn.addEventListener('click', async () => {
            btn.textContent = 'Clearing...';
            btn.disabled = true;

            try {
                const response = await fetch('{{ route("cart.clear") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    document.querySelector('.cart__table--body').innerHTML = '<tr class="cart__table--body__items"><td colspan="4" class="text-center">Your cart is empty.</td></tr>';
                    updateTotals(data);
                    showGlobalMessage(data.message, 'success');
                } else {
                    showGlobalMessage(data.message, 'error');
                }
            } catch (error) {
                showGlobalMessage('An error occurred while clearing the cart.', 'error');
            } finally {
                btn.textContent = 'Clear Cart';
                btn.disabled = false;
            }
        });
    });

    // Update cart button
    document.querySelector('.cart__summary--footer__btn.cart')?.addEventListener('click', (e) => {
        e.preventDefault();
        showGlobalMessage('Cart is already up to date!', 'success');
    });

    function updateTotals(data) {
        document.querySelector('.subtotal-amount').textContent = `Rs.${data.subtotal}`;
        document.querySelector('.shipping-amount').textContent = `Rs.${data.shipping}`;
        document.querySelector('.tax-amount').textContent = `Rs.${data.tax}`;
        document.querySelector('.grand-amount strong').textContent = `Rs.${data.grandTotal}`;
    }
});
</script>
@endpush
