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
                <div class="row">
                    <div class="col-lg-8">
                        <h2 class="mb-4">Order Details</h2>
                        <div class="mb-4">
                            <h4>Shipping Address</h4>
                            <p>{{ $order->shipping_address }}</p>
                        </div>
                        <div class="mb-4">
                            <h4>Billing Address</h4>
                            <p>{{ $order->billing_address }}</p>
                        </div>
                        <div class="mb-4">
                            <h4>Order Items</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>Rs. {{ number_format($item->price, 2) }}</td>
                                            <td>Rs. {{ number_format($item->price * $item->quantity, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="payment-methods">
                            <h4>Select Payment Method</h4>
                            @foreach($gateways as $gateway)
                                <form action="{{ route('checkout.initiatePayment', $order->id) }}" method="POST" class="mb-2">
                                    @csrf
                                    <input type="hidden" name="gateway_key" value="{{ $gateway->gateway_key }}">
                                    <button type="submit" class="btn primary__btn" onclick="console.log('Payment initiated', { gateway: '{{ $gateway->name }}' })">
                                        Pay with {{ $gateway->name }}
                                    </button>
                                </form>
                            @endforeach
                            <form action="{{ route('checkout.initiatePayment', $order->id) }}" method="POST" class="mb-2">
                                @csrf
                                <input type="hidden" name="gateway_key" value="cod">
                                <button type="submit" class="btn primary__btn" onclick="console.log('COD payment initiated')">
                                    Cash on Delivery
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="cart__summary border-radius-10 p-3">
                            <h4>Order Summary</h4>
                            <table class="table">
                                <tr>
                                    <td>Subtotal</td>
                                    <td>Rs. {{ number_format($cartSummary['subtotal'], 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Tax</td>
                                    <td>Rs. {{ number_format($cartSummary['tax'], 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <td>Rs. {{ number_format($cartSummary['shipping'], 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Discount</td>
                                    <td>-Rs. {{ number_format($cartSummary['couponDiscount'], 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td><strong>Rs. {{ number_format($cartSummary['grandTotal'], 2) }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            console.log('Payment page loaded', { orderId: '{{ $order->id }}' });
        });
    </script>
@endsection
