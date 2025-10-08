@extends('store.layouts.app')

@section('title', 'Products - Vyuga')

@section('content')
    <main class="main__content_wrapper">
        <section class="breadcrumb__section breadcrumb__bg" style="background: url({{ asset('assets/images/product-banner.jpg') }});">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Products</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">{{ $category ?? 'Products' }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="shop__section section--padding">
            <div class="container-fluid">
                <div class="shop__header bg__gray--color d-flex align-items-center justify-content-between mb-30">
                    <button class="widget__filter--btn d-flex d-lg-none align-items-center" data-offcanvas="">
                        <svg class="widget__filter--btn__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28" d="M368 128h80M64 128h240M368 384h80M64 384h240M208 256h240M64 256h80"></path>
                            <circle cx="336" cy="128" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28"></circle>
                            <circle cx="176" cy="256" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28"></circle>
                            <circle cx="336" cy="384" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28"></circle>
                        </svg>
                        <span class="widget__filter--btn__text">Filter</span>
                    </button>
                    <div class="product__view--mode d-flex align-items-center">
                        <div class="product__view--mode__list product__short--by align-items-center d-none d-lg-flex">
                            <label class="product__view--label">Prev Page :</label>
                            <div class="select shop__header--select">
                                <select class="product__view--select">
                                    <option selected="" value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                        <div class="product__view--mode__list product__short--by align-items-center d-none d-lg-flex">
                            <label class="product__view--label">Sort By :</label>
                            <div class="select shop__header--select">
                                <select class="product__view--select">
                                    <option selected="" value="1">Sort by latest</option>
                                    <option value="2">Sort by popularity</option>
                                    <option value="3">Sort by newness</option>
                                    <option value="4">Sort by rating</option>
                                </select>
                            </div>
                        </div>
                        <div class="product__view--mode__list product__view--search d-none d-lg-block">
                            <form class="product__view--search__form" action="#">
                                <label style="border: 1px solid #ccc;">
                                    <input class="product__view--search__input border-0" placeholder="Search by" type="text">
                                </label>
                                <button class="product__view--search__btn" aria-label="shop button" type="submit">
                                    <svg class="product__view--search__btn--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                                        <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <p class="product__showing--count">Showing 1–{{ count($products) }} of {{ count($products) }} results</p>
                </div>

                <div class="row">
                    <div class="col-xl-3 col-lg-4">
                        <div class="shop__sidebar--widget widget__area d-none d-lg-block">
                            <div class="single__widget widget__bg">
                                <h2 class="widget__title h3">Categories</h2>
                                <ul class="widget__categories--menu">
                                    <li class="widget__categories--menu__list">
                                        <label class="widget__categories--menu__label d-flex align-items-center">
                                            <span class="widget__categories--menu__text">Women</span>
                                            <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394">
                                                <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                                            </svg>
                                        </label>
                                        <ul class="widget__categories--sub__menu" style="display: none; box-sizing: border-box;">
                                            <li class="widget__categories--sub__menu--list">
                                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="{{ route('shop') }}">
                                                    <span class="widget__categories--sub__menu--text">Kurti</span>
                                                </a>
                                            </li>
                                            <li class="widget__categories--sub__menu--list">
                                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="{{ route('shop') }}">
                                                    <span class="widget__categories--sub__menu--text">Tshirts</span>
                                                </a>
                                            </li>
                                            <li class="widget__categories--sub__menu--list">
                                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="{{ route('shop') }}">
                                                    <span class="widget__categories--sub__menu--text">Lehenga</span>
                                                </a>
                                            </li>
                                            <li class="widget__categories--sub__menu--list">
                                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="{{ route('shop') }}">
                                                    <span class="widget__categories--sub__menu--text">Dresses and Gowns</span>
                                                </a>
                                            </li>
                                            <li class="widget__categories--sub__menu--list">
                                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="{{ route('shop') }}">
                                                    <span class="widget__categories--sub__menu--text">Saree</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="widget__categories--menu__list">
                                        <label class="widget__categories--menu__label d-flex align-items-center">
                                            <span class="widget__categories--menu__text">New In</span>
                                            <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394">
                                                <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                                            </svg>
                                        </label>
                                        <ul class="widget__categories--sub__menu" style="box-sizing: border-box; display: none;">
                                            <li class="widget__categories--sub__menu--list">
                                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="{{ route('shop') }}">
                                                    <span class="widget__categories--sub__menu--text">Tshirts</span>
                                                </a>
                                            </li>
                                            <li class="widget__categories--sub__menu--list">
                                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="{{ route('shop') }}">
                                                    <span class="widget__categories--sub__menu--text">Sarees</span>
                                                </a>
                                            </li>
                                            <li class="widget__categories--sub__menu--list">
                                                <a class="widget__categories--sub__menu--link d-flex align-items-center" href="{{ route('shop') }}">
                                                    <span class="widget__categories--sub__menu--text">Designer Dresses</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="single__widget price__filter widget__bg">
                                <h2 class="widget__title h3">Filter By Price</h2>
                                <form class="price__filter--form" action="#">
                                    <div class="price__filter--form__inner mb-15 d-flex align-items-center">
                                        <div class="price__filter--group">
                                            <label class="price__filter--label" for="Filter-Price-GTE2">From</label>
                                            <div class="price__filter--input border-radius-5 d-flex align-items-center">
                                                <span class="price__filter--currency">Rs.</span>
                                                <label>
                                                    <input class="price__filter--input__field border-0" name="filter.v.price.gte" type="number" placeholder="250.00" min="0" max="250.00">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="price__divider">
                                            <span>-</span>
                                        </div>
                                        <div class="price__filter--group">
                                            <label class="price__filter--label" for="Filter-Price-LTE2">To</label>
                                            <div class="price__filter--input border-radius-5 d-flex align-items-center">
                                                <span class="price__filter--currency">Rs.</span>
                                                <label>
                                                    <input class="price__filter--input__field border-0" name="filter.v.price.lte" type="number" min="0" placeholder="200000.00" max="200000.00">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="price__filter--btn primary__btn" type="submit">Filter</button>
                                </form>
                            </div>
                            <div class="single__widget widget__bg">
                                <h2 class="widget__title h3">Brands</h2>
                                <ul class="widget__tagcloud">
                                    <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="{{ route('shop') }}">Rangoli</a></li>
                                    <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="{{ route('shop') }}">Radhika</a></li>
                                    <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="{{ route('shop') }}">Mandir</a></li>
                                    <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="{{ route('shop') }}">Neeru's</a></li>
                                    <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="{{ route('shop') }}">Kashish</a></li>
                                    <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="{{ route('shop') }}">Kalanjali</a></li>
                                    <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="{{ route('shop') }}">Kalamandir</a></li>
                                    <li class="widget__tagcloud--list"><a class="widget__tagcloud--link" href="{{ route('shop') }}">Sri Lakshmi</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-8">
                        <div class="shop__product--wrapper">
                            <div class="tab_content">
                                <div id="product_grid" class="tab_pane active show">
                                    <div class="product__section--inner product__grid--inner">
                                        <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-2 mb--n30">
                                            @foreach ($products as $product)
                                                <div class="col mb-30">
                                                    <div class="product__items">
                                                        <div class="product__items--thumbnail">
                                                            <a class="product__items--link" href="{{ route('product.detail', $product['slug']) }}">
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
                                                            <h4 class="product__items--content__title"><a href="{{ route('product.detail', $product['slug']) }}">{{ $product['name'] }}</a></h4>
                                                            <div class="product__items--price">
                                                                @if (isset($product['old_price']))
                                                                    <span class="old__price">Rs.{{ number_format($product['old_price'], 2) }}</span>
                                                                @endif
                                                                <span class="current__price">Rs.{{ number_format($product['price'], 2) }}</span>
                                                            </div>
                                                            <div class="product__items--action d-flex">
                                                                <a class="product__items--action__btn" data-open="modal1" data-slug="{{ $product['slug'] }}" href="javascript:void(0)">
                                                                    <span class="">Choose Options</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pagination__area bg__gray--color">
                                <nav class="pagination justify-content-center">
                                    <ul class="pagination__wrapper d-flex align-items-center justify-content-center">
                                        <li class="pagination__list">
                                            <a href="{{ route('shop') }}" class="pagination__item--arrow link">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M244 400L100 256l144-144M120 256h292"></path>
                                                </svg>
                                                <span class="visually-hidden">pagination arrow</span>
                                            </a>
                                        </li>
                                        <li class="pagination__list"><span class="pagination__item pagination__item--current">1</span></li>
                                        <li class="pagination__list">
                                            <a href="{{ route('shop') }}" class="pagination__item--arrow link">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M268 112l144 144-144 144M392 256H100"></path>
                                                </svg>
                                                <span class="visually-hidden">pagination arrow</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="shipping__section2 shipping__style3 section--padding pt-0">
            <div class="container">
                <div class="shipping__section2--inner shipping__style3--inner d-flex justify-content-between">
                    <div class="shipping__items2 d-flex align-items-center">
                        <div class="shipping__items2--icon">
                            <img src="{{ asset('assets/images/shipping1.png') }}" alt="">
                        </div>
                        <div class="shipping__items2--content">
                            <h2 class="shipping__items2--content__title h3">Shipping</h2>
                            <p class="shipping__items2--content__desc">From handpicked sellers</p>
                        </div>
                    </div>
                    <div class="shipping__items2 d-flex align-items-center">
                        <div class="shipping__items2--icon">
                            <img src="{{ asset('assets/images/shipping2.png') }}" alt="">
                        </div>
                        <div class="shipping__items2--content">
                            <h2 class="shipping__items2--content__title h3">Payment</h2>
                            <p class="shipping__items2--content__desc">From handpicked sellers</p>
                        </div>
                    </div>
                    <div class="shipping__items2 d-flex align-items-center">
                        <div class="shipping__items2--icon">
                            <img src="{{ asset('assets/images/shipping3.png') }}" alt="">
                        </div>
                        <div class="shipping__items2--content">
                            <h2 class="shipping__items2--content__title h3">Return</h2>
                            <p class="shipping__items2--content__desc">From handpicked sellers</p>
                        </div>
                    </div>
                    <div class="shipping__items2 d-flex align-items-center">
                        <div class="shipping__items2--icon">
                            <img src="{{ asset('assets/images/shipping4.png') }}" alt="">
                        </div>
                        <div class="shipping__items2--content">
                            <h2 class="shipping__items2--content__title h3">Support</h2>
                            <p class="shipping__items2--content__desc">From handpicked sellers</p>
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
