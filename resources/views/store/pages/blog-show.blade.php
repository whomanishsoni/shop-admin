@extends('store.layouts.app')

@section('title', 'Vyuga - ' . $blogPost->title)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="blog__details">
                    <div class="blog__thumbnail">
                        <div class="blog__thumbnail--container">
                            <img class="blog__thumbnail--img" src="{{ asset($blogPost->featured_image ? 'storage/' . $blogPost->featured_image : 'assets/images/blog/placeholder.jpg') }}" alt="{{ $blogPost->title }}">
                        </div>
                    </div>
                    <div class="blog__content">
                        <span class="blog__content--meta">Posted on: {{ $blogPost->created_at->format('F d, Y') }}</span>
                        <h1 class="blog__content--title">{{ $blogPost->title }}</h1>
                        <div class="blog__content--full">
                            {!! $blogPost->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .blog__thumbnail--container {
            position: relative;
            width: 100%;
            padding-top: 56.25%; /* 16:9 aspect ratio, adjust as needed (e.g., 100% for 1:1) */
            overflow: hidden;
        }

        .blog__thumbnail--img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        /* Responsive adjustments */
        @media (min-width: 768px) {
            .blog__thumbnail--container {
                padding-top: 40%; /* Adjust aspect ratio for larger screens if needed */
            }
        }
    </style>
@endsection
