@extends('store.layouts.app')

@section('title', 'Order Invoice - Vyuga')

@section('content')
    <main class="main__content_wrapper">
        <section class="breadcrumb__section breadcrumb__bg">
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
                <h2 class="account__content--title h3 mb-20">Invoice for Order {{ $order['order_number'] }}</h2>
                <div class="account__wrapper">
                    <p><strong>Order Date:</strong> {{ $order['date'] }}</p>
                    <p><strong>Payment Status:</strong> {{ $order['payment_status'] }}</p>
                    <p><strong>Status:</strong> {{ $order['status'] }}</p>
                    <p><strong>Total:</strong> Rs.{{ number_format($order['total'], 2) }}</p>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    @include('store.partials.js')
@endpush
