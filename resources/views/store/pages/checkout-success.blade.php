@extends('store.layouts.app')

@section('title', 'Checkout Success - Vyuga')

@section('content')
    <main class="main__content_wrapper">
        <section class="breadcrumb__section breadcrumb__bg" style="background: url({{ asset('assets/images/checkout-banner.jpg') }});">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Thank You</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Checkout Success</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section--padding text-center">
            <div class="container">
                <h2>Thank you for your order!</h2>
                <p>Your order #{{ $order->order_number }} has been placed successfully.</p>
                <p>Total Amount: Rs. {{ number_format($order->total, 2) }}</p>
                <p>Payment Method: {{ ucfirst($order->payment_method) }}</p>
                <a href="{{ route('orders') }}" class="btn primary__btn">View My Orders</a>
            </div>
        </section>
    </main>
@endsection
