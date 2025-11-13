@extends('store.layouts.app')

@section('title', (is_string($category) ? $category : (isset($category->name) ? $category->name : 'Products')) . ' - Waseem Fashion Studio')

@section('content')
<main class="main__content_wrapper">

    <!-- Breadcrumb -->
    <section class="breadcrumb__section breadcrumb__bg" style="background: url({{ asset('assets/images/product-banner.jpg') }}) no-repeat center; background-size: cover;">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">Products</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb__content--menu__items"><span class="text-white">{{ is_string($category) ? $category : (isset($category->name) ? $category->name : 'Products') }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Shop Section -->
    <section class="shop__section section--padding">
        <div class="container-fluid">

            <!-- Header -->
            <div class="shop__header bg__gray--color d-flex align-items-center justify-content-between mb-30 flex-wrap gap-2">
                <button class="widget__filter--btn d-flex d-lg-none align-items-center" data-offcanvas>
                    <svg class="widget__filter--btn__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28"
                              d="M368 128h80M64 128h240M368 384h80M64 384h240M208 256h240M64 256h80"/>
                        <circle cx="336" cy="128" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28"/>
                        <circle cx="176" cy="256" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28"/>
                        <circle cx="336" cy="384" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28"/>
                    </svg>
                    <span class="widget__filter--btn__text">Filter</span>
                </button>

                <div class="product__view--mode d-flex align-items-center gap-2">
                    <form action="{{ route('shop', request()->segment(2)) }}" method="GET">
                        <div class="select shop__header--select">
                            <select class="product__view--select" name="sort" onchange="this.form.submit()">
                                <option value="latest" {{ request('sort','latest')=='latest' ?'selected':'' }}>Sort by latest</option>
                                <option value="popularity" {{ request('sort')=='popularity'?'selected':'' }}>Sort by popularity</option>
                                <option value="rating" {{ request('sort')=='rating'?'selected':'' }}>Sort by rating</option>
                                <option value="newness" {{ request('sort')=='newness'?'selected':'' }}>Sort by newness</option>
                            </select>
                        </div>
                    </form>

                    <form class="product__view--search__form d-none d-lg-flex" action="{{ route('shop', request()->segment(2)) }}" method="GET">
                        <label><input class="product__view--search__input border-0" placeholder="Search by" type="text" name="search" value="{{ request('search') }}"></label>
                        <button class="product__view--search__btn" type="submit">
                            <svg class="product__view--search__btn--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                                <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/>
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <p class="product__showing--count mb-0">Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} results</p>
            </div>

            <div class="row">

                <!-- Desktop Sidebar -->
                <div class="col-xl-3 col-lg-4 d-none d-lg-block">
                    <div class="shop__sidebar--widget widget__area">
                        @include('store.partials.shop-filters')
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="col-xl-9 col-lg-8">
                    <div class="shop__product--wrapper">
                        <div class="tab_content">
                            <div id="product_grid" class="tab_pane active show">
                                <div class="product__section--inner product__grid--inner">
                                    @if ($products->isEmpty())
                                        <p class="text-center">No products found.</p>
                                    @else
                                        <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-2 mb--n30">
                                            @foreach ($products as $product)
                                                <div class="col mb-30">
                                                    <div class="product__items">
                                                        <div class="product__items--thumbnail">
                                                            <a class="product__items--link" href="{{ route('product.detail', $product['slug']) }}">
                                                                <img class="product__items--img product__primary--img" src="{{ $product['image_primary'] }}" alt="{{ $product['name'] }}">
                                                                <img class="product__items--img product__secondary--img" src="{{ $product['image_secondary'] }}" alt="{{ $product['name'] }}">
                                                            </a>
                                                            @if ($product['on_sale'])
                                                                <div class="product__badge">
                                                                    <span class="product__badge--items sale">Sale</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="product__items--content text-center">
                                                            <h4 class="product__items--content__title"><a href="{{ route('product.detail', $product['slug']) }}">{{ $product['name'] }}</a></h4>
                                                            <div class="product__items--price">
                                                                @if ($product['old_price'])
                                                                    <span class="old__price">Rs.{{ number_format($product['old_price'], 2) }}</span>
                                                                @endif
                                                                <span class="current__price">Rs.{{ number_format($product['price'], 2) }}</span>
                                                            </div>
                                                            <div class="product__items--action d-flex justify-content-center">
                                                                <a class="product__items--action__btn" data-open="modal1" data-slug="{{ $product['slug'] }}" href="javascript:void(0)">
                                                                    <span>Choose Options</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="pagination__area bg__gray--color mt-4">
                            <nav class="pagination justify-content-center">
                                {{ $products->appends(request()->query())->links('vendor.pagination.custom') }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Off-canvas Filter -->
            <div class="offcanvas__filter--sidebar">
                <div class="offcanvas__filter--inner">
                    <div class="offcanvas__filter--header d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                        <h2 class="offcanvas__filter--title mb-0">Filters</h2>
                        <button class="offcanvas__filter--close" data-offcanvas>
                            <svg width="14" height="14" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 1L1 11" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M1 1L11 11" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                        </button>
                    </div>
                    <div class="offcanvas__filter--body" style="max-height: 78vh; overflow-y: auto; padding: 1rem 0;">
                        @include('store.partials.shop-filters')
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Shipping -->
    <section class="shipping__section2 shipping__style3 section--padding pt-0">
        <div class="container">
            <div class="shipping__section2--inner shipping__style3--inner d-flex justify-content-between flex-wrap">
                <div class="shipping__items2 d-flex align-items-center">
                    <div class="shipping__items2--icon"><img src="{{ asset('assets/images/shipping1.png') }}" alt="Shipping"></div>
                    <div class="shipping__items2--content"><h2 class="h3">Shipping</h2><p>From handpicked sellers</p></div>
                </div>
                <div class="shipping__items2 d-flex align-items-center">
                    <div class="shipping__items2--icon"><img src="{{ asset('assets/images/shipping2.png') }}" alt="Payment"></div>
                    <div class="shipping__items2--content"><h2 class="h3">Payment</h2><p>Secure payment options</p></div>
                </div>
                <div class="shipping__items2 d-flex align-items-center">
                    <div class="shipping__items2--icon"><img src="{{ asset('assets/images/shipping3.png') }}" alt="Return"></div>
                    <div class="shipping__items2--content"><h2 class="h3">Return</h2><p>Easy return policy</p></div>
                </div>
                <div class="shipping__items2 d-flex align-items-center">
                    <div class="shipping__items2--icon"><img src="{{ asset('assets/images/shipping4.png') }}" alt="Support"></div>
                    <div class="shipping__items2--content"><h2 class="h3">Support</h2><p>24/7 customer support</p></div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
    @include('store.partials.js')
    @include('store.partials.quickview-js')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterBtn = document.querySelector('.widget__filter--btn[data-offcanvas]');
            const sidebar = document.querySelector('.offcanvas__filter--sidebar');
            const closeBtn = document.querySelector('.offcanvas__filter--close[data-offcanvas]');

            if (filterBtn && sidebar && closeBtn) {
                filterBtn.addEventListener('click', () => sidebar.classList.add('active'));
                closeBtn.addEventListener('click', () => sidebar.classList.remove('active'));
                document.addEventListener('click', e => {
                    if (!e.target.closest('.offcanvas__filter--sidebar') && !e.target.closest('.widget__filter--btn')) {
                        sidebar.classList.remove('active');
                    }
                });
            }



            // Auto-submit on Enter key
            document.querySelectorAll('.price__filter--input__field').forEach(input => {
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        this.closest('form').submit();
                    }
                });
            });
        });
    </script>
    <style>
        .product__items--thumbnail {
            aspect-ratio: 3 / 4;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
        }

        .product__items--img.product__primary--img,
        .product__items--img.product__secondary--img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }
    </style>
@endpush
