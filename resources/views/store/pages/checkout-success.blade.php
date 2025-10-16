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
                <div class="cart__summary border-radius-10 p-3" style="max-width: 600px; margin: 0 auto;">
                    <span class="success-icon" style="font-size: 48px; display: block; margin-bottom: 20px;">🎉</span>
                    <h2 class="cart__content--title mb-20">Thank You for Your Order!</h2>
                    <p class="cart__content--desc mb-15">Your order <strong>#{{ $order->order_number }}</strong> has been placed successfully.</p>
                    <p class="cart__content--desc mb-15">Total Amount: <strong>Rs. {{ number_format($order->total, 2) }}</strong></p>
                    <p class="cart__content--desc mb-20">Payment Method: <strong>{{ ucfirst($order->payment_method) }}</strong></p>
                    <p class="cart__content--desc mb-20">Redirecting to your orders in <span id="countdown">7</span> seconds...</p>
                    <a href="{{ route('orders') }}" class="btn primary__btn border-radius-5">View My Orders</a>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    @include('store.partials.js')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Countdown timer
            let timeLeft = 7;
            const countdownElement = document.getElementById('countdown');
            const timer = setInterval(() => {
                timeLeft--;
                countdownElement.textContent = timeLeft;
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    window.location.href = '{{ route("orders") }}';
                }
            }, 1000);

            // Prevent form resubmission on page reload
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        });
    </script>
@endpush
