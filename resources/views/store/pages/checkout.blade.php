@extends('store.layouts.app')

@section('title', 'Checkout - Vyuga')

@section('content')
    <main class="main__content_wrapper">
        <section class="breadcrumb__section breadcrumb__bg" style="background: url({{ asset('assets/images/checkout-banner.jpg') }});">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Shopping Cart</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">Checkout</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="cart__section section--padding">
            <div class="container-fluid">
                <div class="row cart__section--inner">
                    <div class="col-lg-8">
                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <div class="checkout__content--step section__contact--information">
                                <div class="section__header checkout__section--header d-flex align-items-center justify-content-between mb-25">
                                    <h2 class="section__header--title h3">Contact information</h2>
                                    <p class="layout__flex--item">
                                        Already have an account?
                                        <a class="layout__flex--item__link" href="{{ route('login') }}">Log in</a>
                                    </p>
                                </div>
                                <div class="checkout__content--step section__shipping--address pt-10">
                                    <div class="checkout__content--step__inner3 border-radius-5">
                                        <div class="checkout__address--content__header">
                                            <div class="row customer__information--list" style="width:100%">
                                                <div class="col-lg-6 mb-12 customer__information--step">
                                                    <h4 class="customer__information--subtitle h5">Billing Address</h4>
                                                    <ul>
                                                        <li><span class="customer__information--text">Mr. Rajesh</span></li>
                                                        <li><span class="customer__information--text">#101, Road No.1</span></li>
                                                        <li><span class="customer__information--text">Bank House Colony,</span></li>
                                                        <li><span class="customer__information--text">Hyderabad, Telangana - 500001</span></li>
                                                    </ul>
                                                </div>
                                                <div class="col-lg-6 mb-12 customer__information--step">
                                                    <h4 class="customer__information--subtitle h5">Shipping Address</h4>
                                                    <ul>
                                                        <li><span class="customer__information--text"></span></li>
                                                        <li><span class="customer__information--text"></span></li>
                                                        <li><span class="customer__information--text"></span></li>
                                                        <li><span class="customer__information--text"></span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="shipping__contact--box__list" style="border-top:1px solid #ccc">
                                                <div class="shipping__radio--input">
                                                    <input class="shipping__radio--input__field" id="radiobox" name="checkmethod" type="radio" checked>
                                                </div>
                                                <label class="shipping__radio--label" for="radiobox">
                                                    <span class="shipping__radio--label__primary">Same as shipping address</span>
                                                </label>
                                            </div>
                                            <div class="shipping__contact--box__list">
                                                <div class="shipping__radio--input">
                                                    <input class="shipping__radio--input__field" id="radiobox2" name="checkmethod" type="radio">
                                                </div>
                                                <label class="shipping__radio--label" for="radiobox2">
                                                    <span class="shipping__radio--label__primary">Use a different billing address</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="checkout__content--input__box--wrapper">
                                            <div class="row">
                                                <div class="col-lg-6 mb-12">
                                                    <div class="checkout__input--list">
                                                        <label>
                                                            <input class="checkout__input--field border-radius-5" name="first_name" placeholder="First name (optional)" type="text">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-12">
                                                    <div class="checkout__input--list">
                                                        <label>
                                                            <input class="checkout__input--field border-radius-5" name="last_name" placeholder="Last name" type="text" required>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-12">
                                                    <div class="checkout__input--list">
                                                        <label>
                                                            <input class="checkout__input--field border-radius-5" name="company" placeholder="Company (optional)" type="text">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-12">
                                                    <div class="checkout__input--list">
                                                        <label>
                                                            <input class="checkout__input--field border-radius-5" name="address1" placeholder="Address1" type="text" required>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-12">
                                                    <div class="checkout__input--list">
                                                        <label>
                                                            <input class="checkout__input--field border-radius-5" name="address2" placeholder="Apartment, suite, etc. (optional)" type="text">
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-12">
                                                    <div class="checkout__input--list">
                                                        <label>
                                                            <input class="checkout__input--field border-radius-5" name="city" placeholder="City" type="text" required>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-12">
                                                    <div class="checkout__input--list checkout__input--select select">
                                                        <label class="checkout__select--label" for="country">Country/region</label>
                                                        <select class="checkout__input--select__field border-radius-5" id="country" name="country">
                                                            <option value="India" selected>India</option>
                                                            <option value="United States">United States</option>
                                                            <option value="Netherlands">Netherlands</option>
                                                            <option value="Afghanistan">Afghanistan</option>
                                                            <option value="Albania">Albania</option>
                                                            <option value="Antigua Barbuda">Antigua Barbuda</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-12">
                                                    <div class="checkout__input--list">
                                                        <label>
                                                            <input class="checkout__input--field border-radius-5" name="postal_code" placeholder="Postal code" type="text" required>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__content--step__footer d-flex align-items-center">
                                <button type="submit" class="continue__shipping--btn primary__btn border-radius-5">Continue To Shipping</button>
                                <a class="previous__link--content" href="{{ route('cart') }}">Return to cart</a>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <div class="cart__summary border-radius-10">
                            <div class="cart__table checkout__product--table">
                                <table class="cart__table--inner">
                                    <tbody class="cart__table--body">
                                        <tr class="cart__table--body__items">
                                            <td class="cart__table--body__list">
                                                <div class="product__image two d-flex align-items-center">
                                                    <div class="product__thumbnail border-radius-5">
                                                        <a href="{{ route('product.detail', 'casual-formal-blazer') }}"><img class="border-radius-5" src="{{ asset('assets/images/product/p10.jpg') }}" alt="cart-product"></a>
                                                        <span class="product__thumbnail--quantity">2</span>
                                                    </div>
                                                    <div class="product__description">
                                                        <h3 class="product__description--name h4"><a href="{{ route('product.detail', 'casual-formal-blazer') }}">Casual Formal Blazer for Women</a></h3>
                                                        <span class="product__description--variant text-black">COLOR: Cream</span>
                                                        <span class="product__description--variant text-black">SIZE: M</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="cart__table--body__list">
                                                <span class="cart__price">Rs. 4400.00</span>
                                            </td>
                                        </tr>
                                        <tr class="cart__table--body__items">
                                            <td class="cart__table--body__list">
                                                <div class="cart__product d-flex align-items-center">
                                                    <div class="product__thumbnail border-radius-5">
                                                        <a href="{{ route('product.detail', 'rhysley-rayon-red-kurti') }}"><img class="border-radius-5" src="{{ asset('assets/images/product/p2.jpg') }}" alt="cart-product"></a>
                                                        <span class="product__thumbnail--quantity">1</span>
                                                    </div>
                                                    <div class="product__description">
                                                        <h3 class="product__description--name h4"><a href="{{ route('product.detail', 'rhysley-rayon-red-kurti') }}">Rhysley Rayon Red Kurti</a></h3>
                                                        <span class="product__description--variant text-black">COLOR: Red</span>
                                                        <span class="product__description--variant text-black">SIZE: M</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="cart__table--body__list">
                                                <span class="cart__price">Rs. 1840.00</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="coupon__code mb-30">
                                <h3 class="coupon__code--title">Coupon Apply</h3>
                                <div class="coupon__code--field d-flex">
                                    <label>
                                        <input class="coupon__code--field__input border-radius-5" name="coupon_code" placeholder="Coupon code" type="text">
                                    </label>
                                    <button class="coupon__code--field__btn primary__btn" type="button">Apply Coupon</button>
                                </div>
                            </div>
                            <div class="cart__summary--total mb-20">
                                <table class="cart__summary--total__table">
                                    <tbody>
                                        <tr class="cart__summary--total__list">
                                            <td class="cart__summary--total__title text-left">SUBTOTAL</td>
                                            <td class="cart__summary--amount text-right">Rs. 6240.00</td>
                                        </tr>
                                        <tr class="cart__summary--total__list">
                                            <td class="cart__summary--total__title text-left">Shipping Fee</td>
                                            <td class="cart__summary--amount text-right">Rs. 0.00</td>
                                        </tr>
                                        <tr class="cart__summary--total__list">
                                            <td class="cart__summary--total__title text-left">Tax(18%)</td>
                                            <td class="cart__summary--amount text-right">Rs. 748.00</td>
                                        </tr>
                                        <tr class="cart__summary--total__list">
                                            <td class="cart__summary--total__title text-left"><strong>GRAND TOTAL</strong></td>
                                            <td class="cart__summary--amount text-right"><strong>Rs. 6988.00</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="cart__summary--footer">
                                <ul class="d-flex justify-content-between">
                                    <li><a class="cart__summary--footer__btn primary__btn checkout" href="{{ route('payment') }}">Pay Now</a></li>
                                </ul>
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
@endpush
