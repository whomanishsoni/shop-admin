@extends('store.layouts.app')

@section('title', 'About Us - Vyuga')

@section('content')
    <main class="main__content_wrapper">
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <h1 class="breadcrumb__content--title text-white mb-25">About Us</h1>
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb__content--menu__items"><span class="text-white">About Us</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="my__account--section section--padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="account__content--title h3 mb-20">About Us</h2>
                        <p>Welcome to <strong>Vyuga,</strong> your ultimate online destination for stylish, high-quality women’s clothing. We believe fashion is more than just dressing up — it’s a way to express your individuality, confidence, and personality. Our mission is to bring you a thoughtfully curated collection of kurtis, tops, and trendy apparel that blends comfort, elegance, and affordability.<br /><br />

                            Founded with a passion for style and customer satisfaction, <strong>Vyuga</strong> was created to make fashion accessible to every woman, no matter where she lives. Whether you’re looking for something chic for the office, casual for a day out, or elegant for festive occasions, our versatile designs cater to every mood and moment.<br /><br />

                            At <strong>Vyuga,</strong> we prioritize quality and craftsmanship. Each product in our collection is selected for its premium fabrics, flattering fits, and on-trend styles. We work closely with trusted manufacturers and designers to ensure that every piece meets our high standards before it reaches you.<br /><br />

                            Shopping at <strong>Vyuga</strong> is more than just a purchase — it’s an experience. Our easy-to-use online store, secure payment options, and fast delivery ensure a smooth and enjoyable shopping journey. We also provide responsive customer support, because your satisfaction is our priority.<br /><br />

                            What makes us special? It’s our commitment to combining style with comfort, trend with tradition, and quality with affordability. We’re not just selling clothes; we’re helping you build a wardrobe that reflects who you are.<br /><br />

                            Join thousands of women who trust <strong>Vyuga</strong> to keep them fashionable all year round. Stay connected through our newsletter to get early access to new collections, exclusive offers, and style inspiration.<br /><br />

                            At <strong>Vyuga,</strong> your style is our passion, and we’re here to make sure you always look and feel your best.<br />

                            <strong>Your style. Your story. Vyuga.</strong>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    @include('store.partials.js')
@endpush
