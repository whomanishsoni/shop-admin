@extends('store.layouts.app')

@section('title', 'Shop Online Fashion – Waseem Fashion Studio')

@section('content')
    <main class="main__content_wrapper">
        @include('store.partials.slider')

        <section class="banner__section banner__style2 section--padding" style="background-color: #f7f3f3;">
            <div class="section__heading text-center mb-35">
                <h2 class="section__heading--maintitle">Shop by category</h2>
            </div>
            <div class="container-fluid">
                <div class="row mb--n28 text-center">
                    @foreach ($subcategories as $subcategory)
                        <div class="col-lg-3 col-md-order mb-28">
                            <div class="banner__items position__relative" style="border-radius: 10px 10px 10px 10px; overflow: hidden;">
                                <a class="banner__items--thumbnail" href="{{ $subcategory['url'] }}">
                                    <img class="banner__items--thumbnail__img" src="{{ asset($subcategory['image']) }}" alt="{{ $subcategory['name'] }}" class="img-fluid">
                                    <div class="style2" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 2px 15px; border-radius: 5px; min-width: 150px;">
                                        <h3 class="banner__items--content__title style2">{{ $subcategory['name'] }}</h3>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

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
                            <div class="product__swiper--column3 swiper swiper-initialized swiper-horizontal swiper-pointer-events">
                                <div class="swiper-wrapper" id="swiper-wrapper-8bd9a33f36314f07" aria-live="off" style="transform: translate3d(-1125px, 0px, 0px); transition-duration: 300ms;">
                                    @foreach ($products as $product)
                                        <div class="swiper-slide" style="width: 345px; margin-right: 30px;" role="group" aria-label="{{ $loop->index + 1 }} / {{ $products->count() }}" data-swiper-slide-index="{{ $loop->index }}">
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
                                                    {{-- <div class="product__items--action d-flex">
                                                        <a class="product__items--action__btn" data-open="modal1" href="javascript:void(0)" onclick="loadQuickview('{{ $product['slug'] }}')">
                                                            <span>Choose Options</span>
                                                        </a>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="swiper__nav--btn style3 swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-8bd9a33f36314f07"></div>
                            <div class="swiper__nav--btn style3 swiper-button-prev" tabindex="0" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-8bd9a33f36314f07"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <style>
        @media (max-width: 767px) {
            .new__product--section .product__swiper--column3 .product__items--action {
                display: block !important;
            }
            .new__product--section .product__swiper--column3 .product__items--action__btn {
                width: 100% !important;
            }
            .new__product--section .product__swiper--column3 .product__items {
                height: 450px !important;
            }
            .new__product--section .product__swiper--column3 .swiper-slide {
                height: 450px !important;
            }
            .new__product--section .product__swiper--column3 .swiper-wrapper {
                height: 450px !important;
            }
            .new__product--section .product__swiper--column3 .product__items--thumbnail {
                height: 340px !important;
            }
            .new__product--section .product__swiper--column3 .product__items--thumbnail .product__items--link img {
                height: 100% !important;
                object-fit: contain !important;
            }
        }
        </style>

        @if($videos->count() > 0)
        <section class="banner__section banner__style2 section--padding" style="background-color: #f7f3f3;">
            <div class="section__heading text-center mb-35">
                <h2 class="section__heading--maintitle">CELEBRITIES & INFLUENCERS</h2>
            </div>
            <div class="container-fluid">
                <div class="row mb--n28">
                    @foreach($videos as $video)
                        <div class="col-lg-3 col-md-order mb-28">
                            <div class="banner__items position__relative" style="border-radius: 10px 10px 10px 10px; overflow: hidden;">
                                <div class="banner__items--thumbnail">
                                    <!-- DYNAMIC VIDEO BLOCK -->
                                    <video
                                        class="banner__items--thumbnail__img img-fluid"
                                        autoplay
                                        muted
                                        loop
                                        playsinline
                                    >
                                        <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    <!-- END DYNAMIC VIDEO BLOCK -->
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <section class="banner__section banner__style2 section--padding" style="background-color: #f7f3f3;">
            <div class="section__heading text-center mb-35">
                <h2 class="section__heading--maintitle">SHOP BY COLLECTION</h2>
            </div>
            <div class="container-fluid">
                <div class="row mb--n28 text-center">
                    @forelse ($collections as $collection)
                        <div class="col-lg-6 col-md-order mb-28">
                            <div class="banner__items position__relative" style="border-radius: 10px 10px 10px 10px; overflow: hidden;">
                                <a class="banner__items--thumbnail" href="{{ $collection['url'] }}">
                                    <img class="banner__items--thumbnail__img" src="{{ asset($collection['image']) }}" alt="{{ $collection['name'] }}" class="img-fluid">
                                    <div class="style2" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 2px 15px; border-radius: 5px; min-width: 150px;">
                                        <h3 class="banner__items--content__title style2">{{ $collection['name'] }}</h3>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p>No collections available at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="new__product--section section--padding">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-md-6 m-auto">
                        <div class="product__collection--content">
                            <div class="section__heading text-center mb-35">
                                <h2 class="section__heading--maintitle">Featured Products</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="new__product--sidebar position__relative">
                            <div class="product__swiper--column3 swiper swiper-initialized swiper-horizontal swiper-pointer-events">
                                <div class="swiper-wrapper" id="swiper-wrapper-featured" aria-live="off">
                                    @forelse ($featuredProducts as $product)
                                        <div class="swiper-slide" style="width: 345px; margin-right: 30px;" role="group" aria-label="{{ $loop->index + 1 }} / {{ $featuredProducts->count() }}" data-swiper-slide-index="{{ $loop->index }}">
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
                                                    {{-- <div class="product__items--action d-flex">
                                                        <a class="product__items--action__btn" data-open="modal1" href="javascript:void(0)" onclick="loadQuickview('{{ $product['slug'] }}')">
                                                            <span>Choose Options</span>
                                                        </a>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="swiper-slide" style="width: 345px;">
                                            <div class="text-center p-5">
                                                <p>No featured products available at the moment.</p>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="swiper__nav--btn style3 swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-featured"></div>
                            <div class="swiper__nav--btn style3 swiper-button-prev" tabindex="0" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-featured"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <br>
        <!-- Start testimonial section -->
        @include('store.pages.testimonials')
        <!-- End testimonial section -->

        <!-- Start blog section -->
        @include('store.pages.blog')
        <!-- End blog section -->
    </main>
@endsection

@push('scripts')
    @include('store.partials.js')
    @include('store.partials.quickview-js')

    <script>
        // Initialize all product sliders
        document.querySelectorAll('.product__swiper--column3').forEach(function(swiperContainer) {
            new Swiper(swiperContainer, {
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
                    nextEl: swiperContainer.parentElement.querySelector('.swiper-button-next'),
                    prevEl: swiperContainer.parentElement.querySelector('.swiper-button-prev'),
                },
            });
        });

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
                loop: false,
                clickable: true,
                spaceBetween: 30,
                breakpoints: {
                    1200: { slidesPerView: 3 },
                    992: { slidesPerView: 3 },
                    768: { slidesPerView: 2 },
                    576: { slidesPerView: 2 },
                    0: { slidesPerView: 1 },
                },
                navigation: {
                    nextEl: ".testimonial__swiper--activation .swiper-button-next",
                    prevEl: ".testimonial__swiper--activation .swiper-button-prev",
                },
                pagination: {
                    el: ".testimonial__pagination",
                    clickable: true,
                },
            });
        }
    </script>
    <style>
        /* Remove bottom border / shadow on hover */
        .product__items:hover,
        .product__items--thumbnail:hover {
            border: none !important;
            box-shadow: none !important;
            transform: none !important;
        }
    </style>
@endpush
