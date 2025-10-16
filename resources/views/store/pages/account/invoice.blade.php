@extends('store.layouts.app')

@section('title', 'Order Invoice - Vyuga')

@section('content')
    <main class="main__content_wrapper">
        <section class="breadcrumb__section breadcrumb__bg" style="background: url({{ asset('assets/images/checkout-banner.jpg') }});">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Order Invoice</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('orders') }}">My Orders</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Invoice</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="my__account--section section--padding">
            <div class="container">
                <div class="cart__summary border-radius-10 p-3" style="max-width: 800px; margin: 0 auto;">
                    <span class="success-icon" style="font-size: 48px; display: block; margin-bottom: 20px;">🎉</span>
                    <h2 class="cart__content--title mb-20">Invoice for Order #{{ $order->order_number }}</h2>
                    <div class="mb-30">
                        <h4 class="cart__content--title mb-15">Order Details</h4>
                        <p class="cart__content--desc mb-10"><strong>Order Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
                        <p class="cart__content--desc mb-10"><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                        <p class="cart__content--desc mb-10"><strong>Order Status:</strong> {{ ucfirst($order->status) }}</p>
                        <p class="cart__content--desc mb-10"><strong>Total:</strong> Rs. {{ number_format($order->total, 2) }}</p>
                        <p class="cart__content--desc mb-10"><strong>Payment Method:</strong> {{ ucfirst($order->payment_method ?? 'N/A') }}</p>
                    </div>
                    <div class="mb-30">
                        <h4 class="cart__content--title mb-15">Shipping Address</h4>
                        <p class="cart__content--desc">{{ $order->shipping_address }}</p>
                    </div>
                    <div class="mb-30">
                        <h4 class="cart__content--title mb-15">Billing Address</h4>
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
                                                        <img class="border-radius-5" src="{{ $item->product->images->first() ? asset('storage/' . $item->product->images->first()->image) : asset('assets/images/product/placeholder.jpg') }}" alt="{{ $item->name }}" style="width: 60px; height: 60px; object-fit: cover;">
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
                    <div class="mb-30">
                        <h4 class="cart__content--title mb-15">Order Summary</h4>
                        <table class="cart__summary--total__table">
                            <tbody>
                                <tr class="cart__summary--total__list">
                                    <td class="cart__summary--total__title text-left">Subtotal</td>
                                    <td class="cart__summary--amount text-right">Rs. {{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr class="cart__summary--total__list">
                                    <td class="cart__summary--total__title text-left">Tax (18%)</td>
                                    <td class="cart__summary--amount text-right">Rs. {{ number_format($order->tax, 2) }}</td>
                                </tr>
                                <tr class="cart__summary--total__list">
                                    <td class="cart__summary--total__title text-left">Shipping</td>
                                    <td class="cart__summary--amount text-right">Rs. {{ number_format($order->shipping, 2) }}</td>
                                </tr>
                                @if($order->discount > 0)
                                    <tr class="cart__summary--total__list">
                                        <td class="cart__summary--total__title text-left text-success">Discount</td>
                                        <td class="cart__summary--amount text-right text-success">-Rs. {{ number_format($order->discount, 2) }}</td>
                                    </tr>
                                @endif
                                <tr class="cart__summary--total__list">
                                    <td class="cart__summary--total__title text-left"><strong>Total</strong></td>
                                    <td class="cart__summary--amount text-right"><strong>Rs. {{ number_format($order->total, 2) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('orders') }}" class="btn primary__btn border-radius-5">Back to Orders</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    @include('store.partials.js')
    <style>
        .divider-line {
            border: 0;
            height: 2px;
            background: #e0e0e0;
            margin: 15px 0;
        }
    </style>
@endpush
