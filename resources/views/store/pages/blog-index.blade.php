@extends('store.layouts.app')

@section('title', 'Blog - Waseem Fashion Studio')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Blog Posts Section -->
            <div class="col-md-9 order-md-1 order-2">
                <div class="section__heading text-center mb-40">
                    <h2 class="section__heading--maintitle">Our Blog</h2>
                </div>
                <!-- Category Filter Section (Mobile Only, After Heading) -->
                <div class="d-lg-none mb-3 order-3">
                    <div class="shop__sidebar--widget widget__area">
                        <div class="d-lg-none mb-3">
                            <button class="btn primary__btn w-100" type="button" data-toggle="collapse" data-target="#categoryFilterCollapse" aria-expanded="false" aria-controls="categoryFilterCollapse">
                                Filter by Category
                            </button>
                        </div>
                        <div class="single__widget widget__bg collapse" id="categoryFilterCollapse">
                            <h2 class="widget__title h3">Categories</h2>
                            <form action="{{ route('blog.index') }}" method="GET" id="categoryFilterForm">
                                <ul class="widget__categories--menu">
                                    @foreach ($categories as $category)
                                        <li class="widget__categories--menu__list">
                                            <label class="widget__categories--menu__label d-flex align-items-center justify-content-between">
                                                <div>
                                                    <input type="checkbox" name="categories[]" value="{{ $category->slug }}"
                                                           @if(in_array($category->slug, (array) request()->get('categories', []))) checked @endif
                                                           class="category-checkbox">
                                                    <span class="widget__categories--menu__text ml-2">{{ $category->name }} ({{ $category->blogPosts->count() }})</span>
                                                </div>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="d-flex">
                                    <button type="submit" class="price__filter--btn primary__btn mt-3 mr-2" style="width: 50%;">Apply Filters</button>
                                    <a href="{{ route('blog.index') }}" class="price__filter--btn primary__btn mt-3" style="width: 50%; text-align: center;">Clear Filters</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Blog Posts Content -->
                <div class="row row-cols-xl-3 row-cols-lg-3 row-cols-md-2 row-cols-1 mb--n30 order-4">
                    @foreach ($blogPosts as $post)
                        <div class="col mb-30">
                            <div class="blog__items">
                                <div class="blog__thumbnail">
                                    <a class="blog__thumbnail--link" href="{{ route('blog.show', $post->slug) }}">
                                        <img class="blog__thumbnail--img" src="{{ asset($post->featured_image ? 'storage/' . $post->featured_image : 'assets/images/blog/placeholder.jpg') }}" style="height:235px" alt="blog-img">
                                    </a>
                                </div>
                                <div class="blog__content">
                                    <span class="blog__content--meta">{{ $post->created_at->format('F d, Y') }}</span>
                                    <h3 class="blog__content--title"><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h3>
                                    <p class="blog__content--excerpt">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                                    <a class="blog__content--btn primary__btn" href="{{ route('blog.show', $post->slug) }}">Read more</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Pagination after 9 posts -->
                @if ($blogPosts->hasPages())
                    <div class="pagination__area bg__gray--color mt-4 order-5">
                        <nav class="pagination justify-content-center">
                            {{ $blogPosts->appends(request()->query())->links('vendor.pagination.custom') }}
                        </nav>
                    </div>
                @endif
            </div>

            <!-- Category Filter Section (Desktop Only) -->
            <div class="col-md-3 order-md-2 order-1 d-none d-lg-block">
                <div class="shop__sidebar--widget widget__area">
                    <div class="single__widget widget__bg">
                        <h2 class="widget__title h3">Categories</h2>
                        <form action="{{ route('blog.index') }}" method="GET" id="categoryFilterFormDesktop">
                            <ul class="widget__categories--menu">
                                @foreach ($categories as $category)
                                    <li class="widget__categories--menu__list">
                                        <label class="widget__categories--menu__label d-flex align-items-center justify-content-between">
                                            <div>
                                                <input type="checkbox" name="categories[]" value="{{ $category->slug }}"
                                                       @if(in_array($category->slug, (array) request()->get('categories', []))) checked @endif
                                                       class="category-checkbox">
                                                <span class="widget__categories--menu__text ml-2">{{ $category->name }} ({{ $category->blogPosts->count() }})</span>
                                            </div>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="d-flex">
                                <button type="submit" class="price__filter--btn primary__btn mt-3 mr-2" style="width: 50%;">Apply Filters</button>
                                <a href="{{ route('blog.index') }}" class="price__filter--btn primary__btn mt-3" style="width: 50%; text-align: center;">Clear Filters</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('store.partials.js')
@endpush
