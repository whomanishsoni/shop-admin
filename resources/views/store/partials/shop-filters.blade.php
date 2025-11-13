{{-- shop-filters.blade.php --}}
<form id="shopFilterForm" action="{{ route('shop', request()->segment(2)) }}" method="GET">

    <!-- Price Filter - FIXED -->
    <div class="single__widget price__filter widget__bg mb-4 ps-3">
        <h2 class="widget__title h3 mb-3">Filter By Price</h2>
        <div class="price__filter--form__inner mb-3 d-flex align-items-center gap-2">
            <div class="price__filter--group flex-fill">
                <label class="price__filter--label d-block mb-1">From</label>
                <div class="price__filter--input border-radius-5 d-flex align-items-center">
                    <span class="price__filter--currency">Rs.</span>
                    <input class="price__filter--input__field border-0 w-100" name="filter[price][gte]"
                           type="number" placeholder="100" min="0" value="{{ request('filter.price.gte') }}">
                </div>
            </div>
            <div class="price__filter--divider"><span>-</span></div>
            <div class="price__filter--group flex-fill">
                <label class="price__filter--label d-block mb-1">To</label>
                <div class="price__filter--input border-radius-5 d-flex align-items-center">
                    <span class="price__filter--currency">Rs.</span>
                    <input class="price__filter--input__field border-0 w-100" name="filter[price][lte]"
                           type="number" placeholder="1200" min="0" value="{{ request('filter.price.lte') }}">
                </div>
            </div>
        </div>
        <button class="price__filter--btn primary__btn w-100" type="submit">Filter</button>
    </div>

        <!-- Subcategories -->
    <div class="single__widget widget__bg mb-4 ps-3">
        <h2 class="widget__title h3 mb-3">Subcategories</h2>
        <ul class="widget__tagcloud d-flex flex-wrap gap-2">
            @foreach ($categories as $category)
                @foreach($category->subcategories as $sub)
                    <li class="widget__tagcloud--list">
                        <a class="widget__tagcloud--link"
                           href="{{ route('shop', request()->segment(2)) }}?subcategory={{ $sub->slug }}">{{ $sub->name }}</a>
                    </li>
                @endforeach
            @endforeach
        </ul>
    </div>

    <!-- Collections -->
    <div class="single__widget widget__bg mb-4 ps-3">
        <h2 class="widget__title h3 mb-3">Collections</h2>
        <ul class="widget__tagcloud d-flex flex-wrap gap-2">
            @foreach ($collections as $collection)
                <li class="widget__tagcloud--list">
                    <a class="widget__tagcloud--link"
                       href="{{ route('shop', request()->segment(2)) }}?collection={{ $collection->slug }}">{{ $collection->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Brands -->
    <div class="single__widget widget__bg mb-4 ps-3">
        <h2 class="widget__title h3 mb-3">Brands</h2>
        <ul class="widget__tagcloud d-flex flex-wrap gap-2">
            @foreach ($brands as $brand)
                <li class="widget__tagcloud--list">
                    <a class="widget__tagcloud--link"
                       href="{{ route('shop', request()->segment(2)) }}?brand={{ $brand->id }}">{{ $brand->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>

</form>

<!-- Clear Button -->
<div class="mt-3 px-3">
    <a href="{{ route('shop') }}" class="price__filter--btn primary__btn w-100 text-center d-block">
        Clear Filters
    </a>
</div>
