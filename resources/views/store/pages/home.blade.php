@extends('store.layouts.app')

@section('title', 'Shop Online Fashion – Vyuga')

@section('content')
    <main class="main__content_wrapper">
        @include('store.partials.slider')

        <section class="new__product--section section--padding">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-md-6 m-auto">
                        <div class="product__collection--content">
                            <div class="section__heading text-center mb-35">
                                <h2 class="section__heading--maintitle">Latest Arrivals</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="new__product--sidebar position__relative">
                            <div class="product__swiper--column3 swiper">
                                <div class="swiper-wrapper">
                                    @foreach ($products as $product)
                                        <div class="swiper-slide">
                                            <div class="product__items">
                                                <div class="product__items--thumbnail">
                                                    <a class="product__items--link" href="{{ $product['product_url'] }}">
                                                        <img class="product__items--img product__primary--img" src="{{ asset($product['image_primary']) }}" alt="product-img">
                                                        <img class="product__items--img product__secondary--img" src="{{ asset($product['image_secondary']) }}" alt="product-img">
                                                    </a>
                                                    @if ($product['on_sale'])
                                                        <div class="product__badge">
                                                            <span class="product__badge--items sale">Sale</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="product__items--content text-center">
                                                    <h4 class="product__items--content__title">
                                                        <a href="{{ $product['product_url'] }}">{{ $product['name'] }}</a>
                                                    </h4>
                                                    <div class="product__items--price">
                                                        @if ($product['on_sale'])
                                                            <span class="old__price">Rs. {{ number_format($product['old_price'], 2) }}</span>
                                                        @endif
                                                        <span class="current__price">Rs. {{ number_format($product['price'], 2) }}</span>
                                                    </div>
                                                    <div class="product__items--action d-flex">
                                                        <a class="product__items--action__btn" data-open="modal1" href="javascript:void(0)" onclick="loadQuickview('{{ $product['slug'] }}')">
                                                            <span>Choose Options</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="swiper__nav--btn style3 swiper-button-next"></div>
                            <div class="swiper__nav--btn style3 swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Start banner section -->
        <section class="banner__section banner__style2 section--padding" style="background-color: #f7f3f3;">
            <div class="section__heading text-center mb-35">
                <h2 class="section__heading--maintitle">Women Collections</h2>
            </div>
            <div class="container-fluid">
                <div class="row mb--n28">
                    <div class="col-lg-3 col-md-order mb-28">
                        <div class="banner__items position__relative">
                            <a class="banner__items--thumbnail" href="{{ route('shop') }}">
                                <img class="banner__items--thumbnail__img" src="{{ asset('assets/images/bestseller.jpg') }}" alt="banner-img" class="img-fluid">
                                <div class="style2">
                                    <h3 class="banner__items--content__title style2">Our Best Sellers <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="icon icon-arrow" viewBox="0 0 14 10"><path fill="currentColor" fill-rule="evenodd" d="M8.537.808a.5.5 0 0 1 .817-.162l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L11.793 5.5H1a.5.5 0 0 1 0-1h10.793L8.646 1.354a.5.5 0 0 1-.109-.546" clip-rule="evenodd"></path></svg></h3>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-order mb-28">
                        <div class="banner__items position__relative">
                            <a class="banner__items--thumbnail" href="{{ route('shop') }}">
                                <img class="banner__items--thumbnail__img" src="{{ asset('assets/images/newlaunch.jpg') }}" alt="banner-img" class="img-fluid">
                                <div class="style2">
                                    <h3 class="banner__items--content__title style2">New Launches <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="icon icon-arrow" viewBox="0 0 14 10"><path fill="currentColor" fill-rule="evenodd" d="M8.537.808a.5.5 0 0 1 .817-.162l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L11.793 5.5H1a.5.5 0 0 1 0-1h10.793L8.646 1.354a.5.5 0 0 1-.109-.546" clip-rule="evenodd"></path></svg></h3>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-order mb-28">
                        <div class="banner__items position__relative">
                            <a class="banner__items--thumbnail" href="{{ route('shop') }}">
                                <img class="banner__items--thumbnail__img" src="{{ asset('assets/images/fullsleave.jpg') }}" alt="banner-img" class="img-fluid">
                                <div class="style2">
                                    <h3 class="banner__items--content__title style2">Full Sleeve Kurti <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="icon icon-arrow" viewBox="0 0 14 10"><path fill="currentColor" fill-rule="evenodd" d="M8.537.808a.5.5 0 0 1 .817-.162l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L11.793 5.5H1a.5.5 0 0 1 0-1h10.793L8.646 1.354a.5.5 0 0 1-.109-.546" clip-rule="evenodd"></path></svg></h3>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-order mb-28">
                        <div class="banner__items position__relative">
                            <a class="banner__items--thumbnail" href="{{ route('shop') }}">
                                <img class="banner__items--thumbnail__img" src="{{ asset('assets/images/halfsleeve.jpg') }}" alt="banner-img" class="img-fluid">
                                <div class="style2">
                                    <h3 class="banner__items--content__title style2">Half Sleeve Kurti <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="icon icon-arrow" viewBox="0 0 14 10"><path fill="currentColor" fill-rule="evenodd" d="M8.537.808a.5.5 0 0 1 .817-.162l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L11.793 5.5H1a.5.5 0 0 1 0-1h10.793L8.646 1.354a.5.5 0 0 1-.109-.546" clip-rule="evenodd"></path></svg></h3>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="banner__section banner__style2 section--padding" style="background-color: #ffffff;">
            <div class="section__heading text-center mb-35">
                <h2 class="section__heading--maintitle">Shop To Be The Main Character</h2>
            </div>
            <div class="container-fluid">
                <div class="row mb--n28">
                    <div class="col-lg-3 col-md-order mb-28">
                        <div class="banner__items position__relative">
                            <a class="banner__items--thumbnail" href="{{ route('shop') }}">
                                <img class="banner__items--thumbnail__img" src="{{ asset('assets/images/product/big-product1.jpg') }}" alt="banner-img">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-order mb-28">
                        <div class="banner__items position__relative">
                            <a class="banner__items--thumbnail" href="{{ route('shop') }}">
                                <img class="banner__items--thumbnail__img" src="{{ asset('assets/images/product/big-product2.jpg') }}" alt="banner-img">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-order mb-28">
                        <div class="banner__items position__relative">
                            <a class="banner__items--thumbnail" href="{{ route('shop') }}">
                                <img class="banner__items--thumbnail__img" src="{{ asset('assets/images/product/big-product4.jpg') }}" alt="banner-img">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-order mb-28">
                        <div class="banner__items position__relative">
                            <a class="banner__items--thumbnail" href="{{ route('shop') }}">
                                <img class="banner__items--thumbnail__img" src="{{ asset('assets/images/product/big-product5.jpg') }}" alt="banner-img">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="testimonial__section section--padding pt-0">
            <div class="container-fluid">
                <div class="section__heading text-center mb-40">
                    <h2 class="section__heading--maintitle">Our Clients Say</h2>
                </div>
                <div class="testimonial__section--inner testimonial__swiper--activation swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testimonial__items text-center">
                                <div class="testimonial__items--thumbnail">
                                    <img class="testimonial__items--thumbnail__img border-radius-50" src="{{ asset('assets/images/testimonial.png') }}" alt="testimonial-img">
                                </div>
                                <div class="testimonial__items--content">
                                    <h3 class="testimonial__items--title">Priya Singh</h3>
                                    <p class="testimonial__items--desc">Absolutely in love with the kurti I bought! The fabric is so soft and comfortable, and the design is just gorgeous. Perfect for both casual and festive wear!</p>
                                    <ul class="rating testimonial__rating d-flex justify-content-center">
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </li>
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </li>
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </li>
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </li>
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial__items text-center">
                                <div class="testimonial__items--thumbnail">
                                    <img class="testimonial__items--thumbnail__img border-radius-50" src="{{ asset('assets/images/testimonial.png') }}" alt="testimonial-img">
                                </div>
                                <div class="testimonial__items--content">
                                    <h3 class="testimonial__items--title">Neha K.</h3>
                                    <p class="testimonial__items--desc">I received so many compliments when I wore my new kurti. The fit is perfect, and the stitching is top-notch. Will definitely shop again!</p>
                                    <ul class="rating testimonial__rating d-flex justify-content-center">
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </li>
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </li>
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </li>
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </li>
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial__items text-center">
                                <div class="testimonial__items--thumbnail">
                                    <img class="testimonial__items--thumbnail__img border-radius-50" src="{{ asset('assets/images/testimonial.png') }}" alt="testimonial-img">
                                </div>
                                <div class="testimonial__items--content">
                                    <h3 class="testimonial__items--title">Sana Reddy</h3>
                                    <p class="testimonial__items--desc">The collection is simply amazing! From casual tops to elegant kurtis, they have it all. Loved the quick delivery and beautiful packaging too!</p>
                                    <ul class="rating testimonial__rating d-flex justify-content-center">
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </li>
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </li>
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </li>
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </li>
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial__items text-center">
                                <div class="testimonial__items--thumbnail">
                                    <img class="testimonial__items--thumbnail__img border-radius-50" src="{{ asset('assets/images/testimonial.png') }}" alt="testimonial-img">
                                </div>
                                <div class="testimonial__items--content">
                                    <h3 class="testimonial__items--title">Resma Khan</h3>
                                    <p class="testimonial__items--desc">Lightweight, comfortable, and stylish – their kurtis are my go-to for daily wear. The colors don’t fade even after multiple washes. Very impressed!</p>
                                    <ul class="rating testimonial__rating d-flex justify-content-center">
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </li>
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </li>
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </li>
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </li>
                                        <li class="rating__list">
                                            <span class="rating__list--icon">
                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial__pagination swiper-pagination"></div>
                </div>
            </div>
        </section>
        <!-- End testimonial section -->

        <!-- Start blog section -->
        @include('store.pages.blog')
        <!-- End blog section -->
    </main>
@endsection

@push('scripts')
    @include('store.partials.js')

    <script>
        // Product Column 3 Slider
        if (document.querySelector(".product__swiper--column3") && document.querySelector(".product__swiper--column3 .swiper-wrapper")) {
            new Swiper(".product__swiper--column3", {
                slidesPerView: 4,
                loop: true,
                autoplay: true,
                spaceBetween: 30,
                breakpoints: {
                    1200: { slidesPerView: 4 },
                    992: { slidesPerView: 3 },
                    768: { slidesPerView: 3, spaceBetween: 30 },
                    480: { slidesPerView: 2, spaceBetween: 20 },
                    0: { slidesPerView: 1 },
                },
                navigation: {
                    nextEl: ".new__product--sidebar .swiper-button-next",
                    prevEl: ".new__product--sidebar .swiper-button-prev",
                },
            });
        }

        // Blog Slider
        if (document.querySelector(".blog__swiper--activation") && document.querySelector(".blog__swiper--activation .swiper-wrapper")) {
            new Swiper(".blog__swiper--activation", {
                slidesPerView: 4,
                loop: true,
                clickable: true,
                spaceBetween: 30,
                breakpoints: {
                    1200: { slidesPerView: 4 },
                    992: { slidesPerView: 3 },
                    768: { slidesPerView: 3, spaceBetween: 30 },
                    480: { slidesPerView: 2, spaceBetween: 20 },
                    0: { slidesPerView: 1 },
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        }

        // Testimonial Slider
        if (document.querySelector(".testimonial__swiper--activation") && document.querySelector(".testimonial__swiper--activation .swiper-wrapper")) {
            new Swiper(".testimonial__swiper--activation", {
                slidesPerView: 3,
                loop: true,
                clickable: true,
                spaceBetween: 30,
                breakpoints: {
                    1200: { slidesPerView: 3 },
                    768: { spaceBetween: 30, slidesPerView: 2 },
                    576: { slidesPerView: 2, spaceBetween: 20 },
                    0: { slidesPerView: 1 },
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });
        }
    </script>
@endpush
