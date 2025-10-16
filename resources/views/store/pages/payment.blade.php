@extends('store.layouts.app')

@section('title', 'Payment - Vyuga')

@section('content')
<main class="main__content_wrapper">
    <section class="breadcrumb__section breadcrumb__bg" style="background: url({{ asset('assets/images/checkout-banner.jpg') }});">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">Payment</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb__content--menu__items"><span class="text-white">Payment</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section class="cart__section section--padding">
            <div class="container-fluid">
                <div class="cart__section--inner">
                    <div class="row">
                        <div class="col-lg-8">
                            <h2 class="cart__title mb-40">Order Details</h2>
                            <div class="mb-30">
                                <h4 class="cart__content--title">Shipping Address</h4>
                                <p class="cart__content--desc">{{ $order->shipping_address }}</p>
                            </div>
                            <div class="mb-30">
                                <h4 class="cart__content--title">Billing Address</h4>
                                <p class="cart__content--desc">{{ $order->billing_address }}</p>
                            </div>
                            <div class="cart__table mb-30">
                                <h4 class="cart__content--title mb-20">Order Items</h4>
                                <hr class="divider-line">
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
                                        @foreach($order->items as $item)
                                            <tr class="cart__table--body__items">
                                                <td class="cart__table--body__list">
                                                    <div class="cart__product d-flex align-items-center">
                                                        <div class="cart__thumbnail">
                                                            <a href="{{ route('product.detail', $item->product->slug) }}">
                                                                <img class="border-radius-5" src="{{ $item->product->images->first() ? asset('storage/' . $item->product->images->first()->image) : asset('assets/images/product/placeholder.jpg') }}" alt="{{ $item->name }}">
                                                            </a>
                                                        </div>
                                                        <div class="cart__content">
                                                            <h4 class="cart__content--title"><a href="{{ route('product.detail', $item->product->slug) }}">{{ $item->name }}</a></h4>
                                                            @if(!empty($item->attributes))
                                                                @foreach(json_decode($item->attributes, true) as $key => $value)
                                                                    <span class="cart__content--variant">{{ strtoupper($key) }}: {{ $value }}</span>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="cart__table--body__list">
                                                    <span class="cart__price">Rs. {{ number_format($item->price, 2) }}</span>
                                                </td>
                                                <td class="cart__table--body__list">
                                                    <span class="cart__price">{{ $item->quantity }}</span>
                                                </td>
                                                <td class="cart__table--body__list">
                                                    <span class="cart__price end">Rs. {{ number_format($item->price * $item->quantity, 2) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="continue__shopping d-flex justify-content-between">
                                <a class="continue__shopping--link" href="{{ route('checkout') }}">Return to Checkout</a>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="cart__summary border-radius-10 p-3">
                                <h3 class="cart__content--title mb-20">Order Summary</h3>
                                <table class="cart__summary--total__table">
                                    <tbody>
                                        <tr class="cart__summary--total__list">
                                            <td class="cart__summary--total__title text-left">Subtotal</td>
                                            <td class="cart__summary--amount text-right">Rs. {{ number_format($cartSummary['subtotal'], 2) }}</td>
                                        </tr>
                                        <tr class="cart__summary--total__list">
                                            <td class="cart__summary--total__title text-left">Tax (18%)</td>
                                            <td class="cart__summary--amount text-right">Rs. {{ number_format($cartSummary['tax'], 2) }}</td>
                                        </tr>
                                        <tr class="cart__summary--total__list">
                                            <td class="cart__summary--total__title text-left">Shipping</td>
                                            <td class="cart__summary--amount text-right">Rs. {{ number_format($cartSummary['shipping'], 2) }}</td>
                                        </tr>
                                        @if($cartSummary['couponDiscount'] > 0)
                                            <tr class="cart__summary--total__list">
                                                <td class="cart__summary--total__title text-left text-success">Discount</td>
                                                <td class="cart__summary--amount text-right text-success">-Rs. {{ number_format($cartSummary['couponDiscount'], 2) }}</td>
                                            </tr>
                                        @endif
                                        <tr class="cart__summary--total__list">
                                            <td class="cart__summary--total__title text-left"><strong>Total</strong></td>
                                            <td class="cart__summary--amount text-right"><strong>Rs. {{ number_format($cartSummary['grandTotal'], 2) }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="payment-methods mt-30">
                                    <h4 class="cart__content--title mb-20">Select Payment Method</h4>
                                    <form action="{{ route('checkout.initiatePayment', $order->id) }}" method="POST" id="paymentForm">
                                        @csrf
                                        <div class="payment__options">
                                            @foreach($gateways as $index => $gateway)
                                                <div class="shipping__contact--box__list mb-10">
                                                    <div class="shipping__radio--input">
                                                        <input class="shipping__radio--input__field"
                                                               id="gateway_{{ $gateway->gateway_key }}"
                                                               name="gateway_key"
                                                               type="radio"
                                                               value="{{ $gateway->gateway_key }}"
                                                               {{ $gateway->gateway_key === 'cod' ? 'checked' : '' }}>
                                                    </div>
                                                    <label class="shipping__radio--label" for="gateway_{{ $gateway->gateway_key }}">
                                                        <span class="shipping__radio--label__primary">{{ $gateway->name }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="cart__summary--footer mt-20 text-center">
                                            <button type="submit" class="primary__btn checkout border-radius-5 w-100" id="payNowButton" style="width: 100% !important;">Complete Payment</button>
                                        </div>
                                    </form>
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

    <style>
        /* Reduce product image size */
        .cart__thumbnail img {
            width: 60px; /* Adjust size as needed */
            height: 60px;
            object-fit: cover;
        }

        /* Style the divider line after Order Items heading */
        .divider-line {
            border: 0;
            height: 2px;
            background: #e0e0e0; /* Light gray divider */
            margin: 15px 0;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const paymentForm = document.getElementById('paymentForm');
            const payNowButton = document.getElementById('payNowButton');
            let isSubmitting = false; // Flag to prevent multiple submissions

            if (paymentForm) {
                paymentForm.addEventListener('submit', async function (e) {
                    e.preventDefault();

                    if (isSubmitting) {
                        return; // Prevent multiple submissions
                    }

                    isSubmitting = true;
                    payNowButton.textContent = 'Processing...';
                    payNowButton.disabled = true;

                    const formData = new FormData(paymentForm);
                    try {
                        const response = await fetch(paymentForm.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (data.success) {
                            showGlobalMessage(data.message || 'Payment initiated successfully! Redirecting...', 'success');
                            // Delay redirect to allow message to be seen
                            setTimeout(() => {
                                window.location.href = '{{ route("checkout.success", $order->id) }}';
                            }, 1500);
                        } else {
                            showGlobalMessage(data.message || 'Failed to initiate payment. Please try again.', 'error');
                            isSubmitting = false;
                            payNowButton.textContent = 'Pay Now';
                            payNowButton.disabled = false;
                        }
                    } catch (error) {
                        showGlobalMessage('An error occurred while processing the payment.', 'error');
                        isSubmitting = false;
                        payNowButton.textContent = 'Pay Now';
                        payNowButton.disabled = false;
                    }
                });
            }

            // Prevent form resubmission on page reload
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        });
    </script>
@endpush
