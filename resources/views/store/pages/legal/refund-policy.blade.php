@extends('store.layouts.app')

@section('title', $pageData->meta_title ?? 'Refund Policy - Vyuga')

@section('meta')
    @if(isset($pageData->meta_description))
        <meta name="description" content="{{ $pageData->meta_description }}">
    @else
        <meta name="description" content="Learn more about Vyuga’s policies and procedures.">
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
                            <h1 class="breadcrumb__content--title text-white mb-25">Refund Policy</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items">
                                    <a class="text-white" href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="breadcrumb__content--menu__items">
                                    <span class="text-white">Refund Policy</span>
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
                        <h2 class="account__content--title h3 mb-20">{{ $pageData->title ?? 'Refund Policy' }}</h2>
                        <div class="page-content">
                            {!! $pageData->content !!}
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
