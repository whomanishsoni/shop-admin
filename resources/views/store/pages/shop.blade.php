@extends('store.layouts.app')

@section('title', 'Products - Vyuga')

@section('content')
    <main class="main__content_wrapper">
        <section class="breadcrumb__section breadcrumb__bg" style="background: url({{ asset('assets/images/product-banner.jpg') }}) no-repeat center; background-size: cover;">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">Products</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">{{ is_string($category) ? $category : $category->name }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="shop__section section--padding">
            <div class="container-fluid">
                <div class="shop__header bg__gray--color d-flex align-items-center justify-content-between mb-30">
                    <button class="widget__filter--btn d-flex align-items-center w-100 d-lg-none" data-offcanvas="">
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
                            <form action="{{ route('shop', request()->segment(2)) }}" method="GET">
                                <label class="product__view--label">Sort By :</label>
                                <div class="select shop__header--select">
                                    <select class="product__view--select" name="sort" onchange="this.form.submit()">
                                        <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Sort by latest</option>
                                        <option value="popularity" {{ request('sort') == 'popularity' ? 'selected' : '' }}>Sort by popularity</option>
                                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Sort by rating</option>
                                        <option value="newness" {{ request('sort') == 'newness' ? 'selected' : '' }}>Sort by newness</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="product__view--mode__list product__view--search d-none d-lg-block">
                            <form class="product__view--search__form" id="shop-search-form" action="{{ route('shop', request()->segment(2)) }}" method="GET">
                                <label style="border: 1px solid #ccc;">
                                    <input
                                        class="product__view--search__input border-0"
                                        id="shop-search-input"
                                        placeholder="Search products..."
                                        type="text"
                                        name="search"
                                        value="{{ request('search') }}"
                                        autocomplete="off"
                                    >
                                </label>
                                <button class="product__view--search__btn" aria-label="search button" type="submit">
                                    <svg class="product__view--search__btn--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                                        <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <p class="product__showing--count">Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} results</p>
                </div>

                <div class="row">
                    <div class="col-xl-3 col-lg-4">
                        <div class="shop__sidebar--widget widget__area d-none d-lg-block">
                            <div class="single__widget widget__bg">
                                <h2 class="widget__title h3">Categories</h2>
                                <ul class="widget__categories--menu">
                                    @foreach ($categories as $category)
                                        <li class="widget__categories--menu__list">
                                            <label class="widget__categories--menu__label d-flex align-items-center">
                                                <a class="widget__categories--menu__text {{ request()->segment(2) == $category->slug ? 'active' : '' }}" href="{{ route('shop', $category->slug) }}">{{ $category->name }}</a>
                                                <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394">
                                                    <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                                                </svg>
                                            </label>
                                            @if ($category->subcategories->count() > 0)
                                                <ul class="widget__categories--sub__menu" style="display: none;">
                                                    @foreach ($category->subcategories as $subcategory)
                                                        <li class="widget__categories--sub__menu--list">
                                                            <a class="widget__categories--sub__menu--link d-flex align-items-center {{ request()->segment(2) == $subcategory->slug ? 'active' : '' }}" href="{{ route('shop', $subcategory->slug) }}">
                                                                <span class="widget__categories--sub__menu--text">{{ $subcategory->name }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="single__widget price__filter widget__bg">
                                <h2 class="widget__title h3">Filter By Price</h2>
                                <form class="price__filter--form" action="{{ route('shop', request()->segment(2)) }}" method="GET">
                                    <div class="price__filter--form__inner mb-15 d-flex align-items-center">
                                        <div class="price__filter--group">
                                            <label class="price__filter--label" for="Filter-Price-GTE2">From</label>
                                            <div class="price__filter--input border-radius-5 d-flex align-items-center">
                                                <span class="price__filter--currency">Rs.</span>
                                                <label>
                                                    <input class="price__filter--input__field border-0" name="filter[v][price][gte]" type="number" placeholder="250.00" min="0" value="{{ request('filter.v.price.gte') }}">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="price__filter--divider">
                                            <span>-</span>
                                        </div>
                                        <div class="price__filter--group">
                                            <label class="price__filter--label" for="Filter-Price-LTE2">To</label>
                                            <div class="price__filter--input border-radius-5 d-flex align-items-center">
                                                <span class="price__filter--currency">Rs.</span>
                                                <label>
                                                    <input class="price__filter--input__field border-0" name="filter[v][price][lte]" type="number" placeholder="200000.00" min="0" value="{{ request('filter.v.price.lte') }}">
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
                                    @foreach ($brands as $brand)
                                        <li class="widget__tagcloud--list">
                                            <a class="widget__tagcloud--link {{ request()->has('brand') && in_array($brand->id, (array)request('brand')) ? 'active' : '' }}" href="{{ route('shop', request()->segment(2)) }}?brand={{ $brand->id }}">{{ $brand->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="single__widget widget__bg">
                                <div class="offcanvas__filter--footer d-lg-block d-none">
                                    <button class="clear__filter--btn primary__btn w-100" type="button" onclick="clearFilters()">Clear Filters</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-8">
                        <div class="shop__product--wrapper">
                            <div class="tab_content">
                                <div id="product_grid" class="tab_pane active show">
                                    <div class="product__section--inner product__grid--inner">
                                        @if ($products->isEmpty())
                                            <p class="text-center">No products found.</p>
                                        @else
                                            <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-2 mb--n30" id="product-grid-container">
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
                                                                    <a class="product__items--action__btn" href="javascript:void(0)" onclick="loadQuickview('{{ $product['slug'] }}')">
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
                            <div class="pagination__area bg__gray--color">
                                <nav class="pagination justify-content-center">
                                    {{ $products->appends(request()->query())->links('vendor.pagination.custom') }}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Filter Sidebar -->
            <div class="offcanvas__filter--sidebar">
                <div class="offcanvas__filter--inner">
                    <div class="offcanvas__filter--header d-flex justify-content-between align-items-center">
                        <h2 class="offcanvas__filter--title mb-0">Filters</h2>
                        <button class="offcanvas__filter--close" data-offcanvas="">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 1L1 11" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M1 1L11 11" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                        </button>
                    </div>
                    <div class="offcanvas__filter--body">
                        <div class="single__widget widget__bg">
                            <h2 class="widget__title h3">Categories</h2>
                            <ul class="widget__categories--menu">
                                @foreach ($categories as $category)
                                    <li class="widget__categories--menu__list">
                                        <label class="widget__categories--menu__label d-flex align-items-center">
                                            <a class="widget__categories--menu__text {{ request()->segment(2) == $category->slug ? 'active' : '' }}" href="{{ route('shop', $category->slug) }}">{{ $category->name }}</a>
                                            <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394">
                                                <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                                            </svg>
                                        </label>
                                        @if ($category->subcategories->count() > 0)
                                            <ul class="widget__categories--sub__menu" style="display: none;">
                                                @foreach ($category->subcategories as $subcategory)
                                                    <li class="widget__categories--sub__menu--list">
                                                        <a class="widget__categories--sub__menu--link d-flex align-items-center {{ request()->segment(2) == $subcategory->slug ? 'active' : '' }}" href="{{ route('shop', $subcategory->slug) }}">
                                                            <span class="widget__categories--sub__menu--text">{{ $subcategory->name }}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="single__widget price__filter widget__bg">
                            <h2 class="widget__title h3">Filter By Price</h2>
                            <form class="price__filter--form" action="{{ route('shop', request()->segment(2)) }}" method="GET">
                                <div class="price__filter--form__inner mb-15 d-flex align-items-center">
                                    <div class="price__filter--group">
                                        <label class="price__filter--label" for="Filter-Price-GTE2">From</label>
                                        <div class="price__filter--input border-radius-5 d-flex align-items-center">
                                            <span class="price__filter--currency">Rs.</span>
                                            <label>
                                                <input class="price__filter--input__field border-0" name="filter[v][price][gte]" type="number" placeholder="250.00" min="0" value="{{ request('filter.v.price.gte') }}">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="price__filter--divider">
                                        <span>-</span>
                                    </div>
                                    <div class="price__filter--group">
                                        <label class="price__filter--label" for="Filter-Price-LTE2">To</label>
                                        <div class="price__filter--input border-radius-5 d-flex align-items-center">
                                            <span class="price__filter--currency">Rs.</span>
                                            <label>
                                                <input class="price__filter--input__field border-0" name="filter[v][price][lte]" type="number" placeholder="200000.00" min="0" value="{{ request('filter.v.price.lte') }}">
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
                                @foreach ($brands as $brand)
                                    <li class="widget__tagcloud--list">
                                        <a class="widget__tagcloud--link {{ request()->has('brand') && in_array($brand->id, (array)request('brand')) ? 'active' : '' }}" href="{{ route('shop', request()->segment(2)) }}?brand={{ $brand->id }}">{{ $brand->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="offcanvas__filter--footer">
                            <button class="clear__filter--btn primary__btn w-100" type="button" onclick="clearFilters()">Clear Filters</button>
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
                            <img src="{{ asset('assets/images/shipping1.png') }}" alt="Shipping">
                        </div>
                        <div class="shipping__items2--content">
                            <h2 class="shipping__items2--content__title h3">Shipping</h2>
                            <p class="shipping__items2--content__desc">From handpicked sellers</p>
                        </div>
                    </div>
                    <div class="shipping__items2 d-flex align-items-center">
                        <div class="shipping__items2--icon">
                            <img src="{{ asset('assets/images/shipping2.png') }}" alt="Payment">
                        </div>
                        <div class="shipping__items2--content">
                            <h2 class="shipping__items2--content__title h3">Payment</h2>
                            <p class="shipping__items2--content__desc">Secure payment options</p>
                        </div>
                    </div>
                    <div class="shipping__items2 d-flex align-items-center">
                        <div class="shipping__items2--icon">
                            <img src="{{ asset('assets/images/shipping3.png') }}" alt="Return">
                        </div>
                        <div class="shipping__items2--content">
                            <h2 class="shipping__items2--content__title h3">Return</h2>
                            <p class="shipping__items2--content__desc">Easy return policy</p>
                        </div>
                    </div>
                    <div class="shipping__items2 d-flex align-items-center">
                        <div class="shipping__items2--icon">
                            <img src="{{ asset('assets/images/shipping4.png') }}" alt="Support">
                        </div>
                        <div class="shipping__items2--content">
                            <h2 class="shipping__items2--content__title h3">Support</h2>
                            <p class="shipping__items2--content__desc">24/7 customer support</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Include Quickview Modal -->
    @include('store.partials.quickview-modal')
@endsection

@push('scripts')
    @include('store.partials.js')

    <!-- SHOP SEARCH RESULTS SCRIPT -->
    <script>
        // Function to clear filters (moved outside IIFE to be globally accessible)
        function clearFilters() {
            window.location.href = `{{ route('shop') }}`; // Redirect to base shop route to show all data
        }

        (function() {
            let shopSearchTimeout = null;
            const shopSearchInput = document.getElementById('shop-search-input');
            const productGridContainer = document.getElementById('product-grid-container');
            const shopSearchForm = document.getElementById('shop-search-form');

            // Function to render initial products
            function renderInitialProducts(products) {
                productGridContainer.innerHTML = '';
                if (products.length === 0) {
                    productGridContainer.innerHTML = '<p class="text-center">No products found.</p>';
                    return;
                }
                products.forEach(product => {
                    const price = parseFloat(product.price);
                    const oldPrice = product.old_price ? parseFloat(product.old_price) : null;
                    const priceHtml = oldPrice
                        ? `<span class="old__price">Rs. ${oldPrice.toFixed(2)}</span> <span class="current__price">Rs. ${price.toFixed(2)}</span>`
                        : `<span class="current__price">Rs. ${price.toFixed(2)}</span>`;

                    const productHtml = `
                        <div class="col mb-30">
                            <div class="product__items">
                                <div class="product__items--thumbnail">
                                    <a class="product__items--link" href="/product/${product.slug}">
                                        <img class="product__items--img product__primary--img" src="${product.image_primary}" alt="${product.name}">
                                        <img class="product__items--img product__secondary--img" src="${product.image_secondary}" alt="${product.name}">
                                    </a>
                                    ${oldPrice ? '<div class="product__badge"><span class="product__badge--items sale">Sale</span></div>' : ''}
                                </div>
                                <div class="product__items--content text-center">
                                    <h4 class="product__items--content__title"><a href="/product/${product.slug}">${product.name}</a></h4>
                                    <div class="product__items--price">${priceHtml}</div>
                                    <div class="product__items--action d-flex justify-content-center">
                                        <a class="product__items--action__btn" href="javascript:void(0)" onclick="loadQuickview('${product.slug}')">
                                            <span>Choose Options</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    productGridContainer.innerHTML += productHtml;
                });
            }

            // Initial render with server-side data
            renderInitialProducts(@json($products->items()));

            if (shopSearchInput && productGridContainer) {
                shopSearchInput.addEventListener('input', function() {
                    const query = this.value.trim();

                    clearTimeout(shopSearchTimeout);

                    if (query.length < 2) {
                        // Re-render initial products when query is cleared or too short
                        renderInitialProducts(@json($products->items()));
                        return;
                    }

                    shopSearchTimeout = setTimeout(() => {
                        fetch(`{{ route('search.suggestions') }}?q=${encodeURIComponent(query)}`, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        })
                        .then(response => response.json())
                        .then(products => {
                            productGridContainer.innerHTML = '';
                            if (products.length === 0) {
                                productGridContainer.innerHTML = '<p class="text-center">No products found.</p>';
                                return;
                            }
                            products.forEach(product => {
                                const price = parseFloat(product.price);
                                const oldPrice = product.old_price ? parseFloat(product.old_price) : null;
                                const priceHtml = oldPrice
                                    ? `<span class="old__price">Rs. ${oldPrice.toFixed(2)}</span> <span class="current__price">Rs. ${price.toFixed(2)}</span>`
                                    : `<span class="current__price">Rs. ${price.toFixed(2)}</span>`;

                                const productHtml = `
                                    <div class="col mb-30">
                                        <div class="product__items">
                                            <div class="product__items--thumbnail">
                                                <a class="product__items--link" href="${product.url}">
                                                    <img class="product__items--img product__primary--img" src="${product.image}" alt="${product.name}">
                                                    <img class="product__items--img product__secondary--img" src="${product.image}" alt="${product.name}">
                                                </a>
                                                ${oldPrice ? '<div class="product__badge"><span class="product__badge--items sale">Sale</span></div>' : ''}
                                            </div>
                                            <div class="product__items--content text-center">
                                                <h4 class="product__items--content__title"><a href="${product.url}">${product.name}</a></h4>
                                                <div class="product__items--price">${priceHtml}</div>
                                                <div class="product__items--action d-flex justify-content-center">
                                                    <a class="product__items--action__btn" href="javascript:void(0)" onclick="loadQuickview('${product.slug}')">
                                                        <span>Choose Options</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                productGridContainer.innerHTML += productHtml;
                            });
                        })
                        .catch(error => {
                            console.error('Shop search error:', error);
                            productGridContainer.innerHTML = '<p class="text-center">Error loading products.</p>';
                        });
                    }, 300);
                });

                // Form submit - reload page with search query
                shopSearchForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const query = shopSearchInput.value.trim();
                    if (query) {
                        window.location.href = `{{ route('shop', request()->segment(2)) }}?search=${encodeURIComponent(query)}`;
                    } else {
                        // Reload the page to show all products
                        window.location.href = `{{ route('shop', request()->segment(2)) }}`;
                    }
                });

                // Quickview functionality
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.product__items--action__btn')) {
                        const slug = e.target.closest('.product__items--action__btn').getAttribute('data-slug');
                        loadQuickview(slug);
                        document.getElementById('modal1').style.display = 'block';
                    }
                });
            }

            // Custom function to initialize mobile filter sidebar
            function initMobileFilter() {
                const filterButton = document.querySelector('.widget__filter--btn');
                const filterSidebar = document.querySelector('.offcanvas__filter--sidebar');
                const closeButton = document.querySelector('.offcanvas__filter--close');

                if (filterButton && filterSidebar && closeButton) {
                    filterButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        filterSidebar.classList.add('active');
                        document.body.classList.add('offcanvas__filter--sidebar_active');
                    });

                    closeButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        filterSidebar.classList.remove('active');
                        document.body.classList.remove('offcanvas__filter--sidebar_active');
                    });

                    // Close sidebar when clicking outside
                    document.addEventListener('click', function(event) {
                        if (!event.target.closest('.offcanvas__filter--sidebar') && !event.target.closest('.widget__filter--btn')) {
                            filterSidebar.classList.remove('active');
                            document.body.classList.remove('offcanvas__filter--sidebar_active');
                        }
                    });
                }
            }

            // Initialize mobile filter on page load
            document.addEventListener('DOMContentLoaded', initMobileFilter);
        })();
    </script>
@endpush
