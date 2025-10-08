@extends('store.layouts.app')

@section('title', 'Wishlist – Vyuga')

@section('content')
    <main class="main__content_wrapper">
        <section class="section--padding">
            <div class="container">
                <h2 class="section__heading--maintitle">My Wishlist</h2>
                <!-- Add wishlist content here, e.g., a list of products -->
                <p>No items in your wishlist yet. Start adding your favorite products!</p>
                <a href="{{ route('shop') }}" class="primary__btn">Continue Shopping</a>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    @include('store.partials.js')
@endpush
