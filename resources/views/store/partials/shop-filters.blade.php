{{-- shop-filters.blade.php --}}
<form id="shopFilterForm" action="{{ route('shop', request()->segment(2)) }}" method="GET">

    <!-- Categories -->
    <div class="single__widget widget__bg mb-4 ps-3">
        <h2 class="widget__title h3 mb-3">Categories</h2>
        <ul class="widget__categories--menu">
            @foreach ($categories as $category)
                <li class="widget__categories--menu__list mb-2">
                    <label class="widget__categories--menu__label d-flex align-items-center">
                        <a class="widget__categories--menu__text {{ request()->segment(2)==$category->slug ? 'text-primary' : '' }}"
                           href="{{ route('shop',$category->slug) }}">{{ $category->name }}</a>
                        @if($category->subcategories->count())
                            <svg class="widget__categories--menu__arrowdown--icon ms-2" xmlns="http://www.w3.org/2000/svg"
                                 width="12.355" height="8.394" viewBox="0 0 10.355 6.394">
                                <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z"
                                      transform="translate(-6 -8.59)" fill="currentColor"/>
                            </svg>
                        @endif
                    </label>

                    @if($category->subcategories->count())
                        <ul class="widget__categories--sub__menu ps-4" style="display:none;">
                            @foreach($category->subcategories as $sub)
                                <li class="widget__categories--sub__menu--list mb-1">
                                    <a class="widget__categories--sub__menu--link {{ request()->segment(2)==$sub->slug ? 'text-primary' : '' }}"
                                       href="{{ route('shop',$sub->slug) }}">{{ $sub->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

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

    <!-- Brands -->
    <div class="single__widget widget__bg mb-4 ps-3">
        <h2 class="widget__title h3 mb-3">Brands</h2>
        <ul class="widget__tagcloud d-flex flex-wrap gap-2">
            @foreach ($brands as $brand)
                <li class="widget__tagcloud--list">
                    <a class="widget__tagcloud--link {{ request('brand')==$brand->id ? 'text-primary' : '' }}"
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
