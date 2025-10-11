@extends('store.layouts.app')

@section('title', $aboutData->meta_title ?? 'About Us - Vyuga')

@section('meta')
    @if(isset($aboutData->meta_description))
        <meta name="description" content="{{ $aboutData->meta_description }}">
    @else
        <meta name="description" content="Discover Vyuga, your go-to online store for stylish and high-quality women’s clothing. Explore our curated collection of kurtis, tops, and trendy apparel designed for comfort, elegance, and affordability.">
    @endif
@endsection

@section('content')
    <main class="main__content_wrapper">
        <!-- Breadcrumb Section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">About Us</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items">
                                    <a class="text-white" href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="breadcrumb__content--menu__items">
                                    <span class="text-white">About Us</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dynamic Content Section -->
        <section class="my__account--section section--padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="account__content--title h3 mb-20">{{ $aboutData->title ?? 'About Us' }}</h2>
                        <div class="page-content">
                            {!! $aboutData->content !!}
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
