@extends('store.layouts.app')

@section('title', $productData['name'] . ' - Vyuga')

@section('content')
    <main class="main__content_wrapper">
        <section class="breadcrumb__section breadcrumb__bg" style="background: url({{ asset('assets/images/product-detail-banner.jpg') }});">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">{{ $productData['category_name'] }}</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('shop', $productData['category_slug']) }}">{{ $productData['category_name'] }}</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">{{ $productData['name'] }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="product__details--section section--padding">
            <div class="container">
                <div class="row row-cols-lg-2 row-cols-md-2">
                    <div class="col">
                        <div class="product__details--media">
                            <div class="product__media--preview swiper">
                                <div class="swiper-wrapper">
                                    @foreach ($productData['images'] as $index => $image)
                                        <div class="swiper-slide">
                                            <div class="product__media--preview__items">
                                                <a class="product__media--preview__items--link glightbox" data-gallery="product-media-preview" href="{{ $image }}">
                                                    <img class="product__media--preview__items--img" src="{{ $image }}" alt="product-media-img">
                                                </a>
                                                <div class="product__media--view__icon">
                                                    <a class="product__media--view__icon--link glightbox" href="{{ $image }}" data-gallery="product-media-preview">
                                                        <svg class="product__media--view__icon--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="22.443" viewBox="0 0 512 512">
                                                            <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                                                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="product__media--nav swiper">
                                <div class="swiper-wrapper">
                                    @foreach ($productData['images'] as $index => $image)
                                        <div class="swiper-slide">
                                            <div class="product__media--nav__items">
                                                <img class="product__media--nav__items--img" src="{{ $image }}" alt="product-nav-img">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper__nav--btn swiper-button-next"></div>
                                <div class="swiper__nav--btn swiper-button-prev"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="product__details--info">
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $productData['slug'] }}">
                                <h2 class="product__details--info__title mb-15">{{ $productData['name'] }}</h2>
                                <div class="product__details--info__price mb-10">
                                    <span class="current__price">Rs.{{ number_format($productData['price'], 2) }}</span>
                                    @if ($productData['old_price'])
                                        <span class="price__divided"></span>
                                        <span class="old__price">Rs.{{ number_format($productData['old_price'], 2) }}</span>
                                    @endif
                                </div>
                                <div class="product__details--info__rating d-flex align-items-center mb-15">
                                    <ul class="rating d-flex justify-content-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <li class="rating__list">
                                                <span class="rating__list--icon">
                                                    <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                        <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="{{ $i <= round($productData['average_rating']) ? 'currentColor' : 'none' }}" stroke="{{ $i <= round($productData['average_rating']) ? 'none' : 'currentColor' }}"></path>
                                                    </svg>
                                                </span>
                                            </li>
                                        @endfor
                                    </ul>
                                    <span class="product__items--rating__count--number">({{ $productData['review_count'] }})</span>
                                </div>
                                <p class="product__details--info__desc mb-15">{!! $productData['short_description'] !!}</p>
                                <div class="product__variant">
                                    @foreach ($productData['attributes'] as $attribute)
                                        <div class="product__variant--list mb-10">
                                            <fieldset class="variant__input--fieldset">
                                                <legend class="product__variant--title mb-8">{{ $attribute['name'] }} :</legend>
                                                @foreach ($attribute['values'] as $index => $value)
                                                    @php
                                                        // Ensure $value['value'] is decoded and flattened into an array of strings
                                                        $rawValues = $value['value'] ?? [];
                                                        $displayValues = is_array($rawValues) ? array_map('strval', $rawValues) : [strval($rawValues)];
                                                    @endphp
                                                    @foreach ($displayValues as $displayValue)
                                                        @if (is_array($displayValue) || is_object($displayValue))
                                                            @continue  <!-- Skip if $displayValue is still an array or object -->
                                                        @endif
                                                        <input id="{{ strtolower($attribute['name']) }}-{{ $index }}-{{ $loop->index }}" name="{{ strtolower($attribute['name']) }}" type="radio" {{ $loop->first && $index === 0 ? 'checked' : '' }} value="{{ $displayValue }}">
                                                        @if (strtolower($attribute['name']) === 'color' && $value['image'])
                                                            <label class="variant__color--value {{ strtolower($displayValue) }}" for="{{ strtolower($attribute['name']) }}-{{ $index }}-{{ $loop->index }}" title="{{ $displayValue }}">
                                                                <img class="variant__color--value__img" src="{{ $value['image'] }}" alt="{{ $displayValue }}">
                                                            </label>
                                                        @else
                                                            <label class="variant__size--value {{ strtolower($displayValue) }}" for="{{ strtolower($attribute['name']) }}-{{ $index }}-{{ $loop->index }}">{{ $displayValue }}</label>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </fieldset>
                                        </div>
                                    @endforeach
                                    <div class="product__variant--list quantity d-flex align-items-center mb-20">
                                        <div class="quantity__box">
                                            <button type="button" class="quantity__value quickview__value--quantity decrease" aria-label="quantity value" value="Decrease Value">-</button>
                                            <label>
                                                <input type="number" class="quantity__number quickview__value--number" name="quantity" value="1" min="1" />
                                            </label>
                                            <button type="button" class="quantity__value quickview__value--quantity increase" aria-label="quantity value" value="Increase Value">+</button>
                                        </div>
                                        <button class="quickview__cart--btn primary__btn" type="submit">Add To Cart</button>
                                    </div>
                                    <div class="product__variant--list mb-15">
                                        <a class="variant__wishlist--icon mb-15" href="{{ route('wishlist.add', ['product_id' => $productData['slug']]) }}" title="Add to wishlist">
                                            <svg class="quickview__variant--wishlist__svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path d="M352.92 80C288 80 256 144 256 144s-32-64-96.92-64c-52.76 0-94.54 44.14-95.08 96.81-1.1 109.33 86.73 187.08 183 252.42a16 16 0 0018 0c96.26-65.34 184.09-143.09 183-252.42-.54-52.67-42.32-96.81-95.08-96.81z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
                                            </svg>
                                            Add to Wishlist
                                        </a>
                                        <button class="variant__buy--now__btn primary__btn" type="submit" formaction="{{ route('cart.add', ['product_id' => $productData['slug'], 'buy_now' => true]) }}">Buy it now</button>
                                    </div>
                                    <div class="product__details--info__meta">
                                        <p class="product__details--info__meta--list"><strong>Product Code:</strong> <span>{{ $productData['sku'] }}</span></p>
                                        <p class="product__details--info__meta--list"><strong>Brand:</strong> <span>{{ $productData['brand_name'] ?? 'N/A' }}</span></p>
                                        <p class="product__details--info__meta--list"><strong>Type:</strong> <span>Women Kurti</span></p>
                                    </div>
                                </div>
                                <div class="guarantee__safe--checkout">
                                    <h5 class="guarantee__safe--checkout__title">Guaranteed Safe Checkout</h5>
                                    <img class="guarantee__safe--checkout__img" src="{{ asset('assets/images/payment-visa-card.png') }}" alt="Payment Image">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="product__details--tab__section section--padding pt-2">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <ul class="product__details--tab d-flex mb-30">
                            <li class="product__details--tab__list active" data-toggle="tab" data-target="#description">Description</li>
                            <li class="product__details--tab__list" data-toggle="tab" data-target="#reviews">Product Reviews</li>
                            <li class="product__details--tab__list" data-toggle="tab" data-target="#information">Additional Info</li>
                        </ul>
                        <div class="product__details--tab__inner border-radius-10">
                            <div class="tab_content">
                                <div id="description" class="tab_pane active show">
                                    <div class="product__tab--content">
                                        <div class="product__tab--content__step mb-30">
                                            <h2 class="product__tab--content__title h4 mb-10">Product Detail</h2>
                                            <p class="product__tab--content__desc">{!! $productData['description'] !!}</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="reviews" class="tab_pane">
                                    <div class="product__reviews">
                                        <div class="product__reviews--header">
                                            <h2 class="product__reviews--header__title h3 mb-20">Customer Reviews</h2>
                                            <div class="reviews__ratting d-flex align-items-center">
                                                <ul class="rating d-flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <li class="rating__list">
                                                            <span class="rating__list--icon">
                                                                <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                                    <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="{{ $i <= round($productData['average_rating']) ? 'currentColor' : 'none' }}" stroke="{{ $i <= round($productData['average_rating']) ? 'none' : 'currentColor' }}"></path>
                                                                </svg>
                                                            </span>
                                                        </li>
                                                    @endfor
                                                </ul>
                                                <span class="reviews__summary--caption">Based on {{ $productData['review_count'] }} reviews</span>
                                            </div>
                                            @auth('customer')
                                                <a class="actions__newreviews--btn primary__btn" href="#writereview">Write A Review</a>
                                            @endauth
                                        </div>
                                        <div class="reviews__comment--area">
                                            @if (empty($productData['reviews']))
                                                <p>No reviews yet.</p>
                                            @else
                                                @foreach ($productData['reviews'] as $review)
                                                    <div class="reviews__comment--list d-flex">
                                                        <div class="reviews__comment--thumb">
                                                            <img src="{{ asset('assets/images/testimonial.png') }}" alt="comment-thumb">
                                                        </div>
                                                        <div class="reviews__comment--content">
                                                            <div class="reviews__comment--top d-flex justify-content-between">
                                                                <div class="reviews__comment--top__left">
                                                                    <h3 class="reviews__comment--content__title h4">{{ $review['customer_name'] }}</h3>
                                                                    <ul class="rating reviews__comment--rating d-flex">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <li class="rating__list">
                                                                                <span class="rating__list--icon">
                                                                                    <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                                                        <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="{{ $i <= $review['rating'] ? 'currentColor' : 'none' }}" stroke="{{ $i <= $review['rating'] ? 'none' : 'currentColor' }}"></path>
                                                                                    </svg>
                                                                                </span>
                                                                            </li>
                                                                        @endfor
                                                                    </ul>
                                                                </div>
                                                                <span class="reviews__comment--content__date">{{ $review['date'] }}</span>
                                                            </div>
                                                            <p class="reviews__comment--content__desc">{{ $review['comment'] }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        @auth('customer')
                                            <div id="writereview" class="reviews__comment--reply__area">
                                                <form action="{{ route('product-reviews.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $productData['slug'] }}">
                                                    <h3 class="reviews__comment--reply__title mb-15">Add a review</h3>
                                                    <div class="reviews__ratting d-flex align-items-center mb-20">
                                                        <ul class="rating d-flex">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <li class="rating__list">
                                                                    <input type="radio" name="rating" id="rating-{{ $i }}" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }}>
                                                                    <label for="rating-{{ $i }}" class="rating__list--icon">
                                                                        <svg class="rating__list--icon__svg" xmlns="http://www.w3.org/2000/svg" width="14.105" height="14.732" viewBox="0 0 10.105 9.732">
                                                                            <path data-name="star - Copy" d="M9.837,3.5,6.73,3.039,5.338.179a.335.335,0,0,0-.571,0L3.375,3.039.268,3.5a.3.3,0,0,0-.178.514L2.347,6.242,1.813,9.4a.314.314,0,0,0,.464.316L5.052,8.232,7.827,9.712A.314.314,0,0,0,8.292,9.4L7.758,6.242l2.257-2.231A.3.3,0,0,0,9.837,3.5Z" transform="translate(0 -0.018)" fill="none" stroke="currentColor"></path>
                                                                        </svg>
                                                                    </label>
                                                                </li>
                                                            @endfor
                                                        </ul>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 mb-10">
                                                            <textarea class="reviews__comment--reply__textarea" name="comment" placeholder="Your Comments....">{{ old('comment') ?: '' }}</textarea>
                                                        </div>
                                                    </div>
                                                    <button class="reviews__comment--btn text-white primary__btn" type="submit">SUBMIT</button>
                                                </form>
                                            </div>
                                        @endauth
                                    </div>
                                </div>
                                <div id="information" class="tab_pane">
                                    <div class="product__tab--content">
                                        <div class="product__tab--content__step mb-30 table-responsive">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th>SKU</th>
                                                        <th>:</th>
                                                        <td>{{ $productData['sku'] }}</td>
                                                    </tr>
                                                    @foreach ($productData['attributes'] as $attribute)
                                                        <tr>
                                                            <th>{{ $attribute['name'] }}</th>
                                                            <th>:</th>
                                                            <td>{{ implode(', ', array_merge(...array_map(function ($val) { return $val['value']; }, $attribute['values']))) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="product__section product__section--style3 section--padding">
            <div class="container product3__section--container">
                <div class="section__heading text-center mb-50">
                    <h2 class="section__heading--maintitle">You may also like</h2>
                </div>
                <div class="product__section--inner product__swiper--column4__activation swiper">
                    <div class="swiper-wrapper">
                        @foreach ($relatedProducts as $related)
                            <div class="swiper-slide">
                                <div class="product__items">
                                    <div class="product__items--thumbnail">
                                        <a class="product__items--link" href="{{ route('product.detail', $related['slug']) }}">
                                            <img class="product__items--img product__primary--img" src="{{ $related['image_primary'] }}" alt="{{ $related['name'] }}">
                                            <img class="product__items--img product__secondary--img" src="{{ $related['image_secondary'] }}" alt="{{ $related['name'] }}">
                                        </a>
                                        @if ($related['on_sale'])
                                            <div class="product__badge">
                                                <span class="product__badge--items sale">Sale</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="product__items--content text-center">
                                        <h4 class="product__items--content__title"><a href="{{ route('product.detail', $related['slug']) }}">{{ $related['name'] }}</a></h4>
                                        <div class="product__items--price">
                                            @if ($related['old_price'])
                                                <span class="old__price">Rs.{{ number_format($related['old_price'], 2) }}</span>
                                            @endif
                                            <span class="current__price">Rs.{{ number_format($related['price'], 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    @include('store.partials.js')
@endpush
