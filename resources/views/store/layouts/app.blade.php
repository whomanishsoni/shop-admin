<!DOCTYPE html>
<html lang="en">
<head>
    @include('store.partials.head')
</head>
<body>
    <div id="preloader" class="preloader">
        <div class="loader"></div>
    </div>
    @include('store.partials.header')

    <main class="main__content_wrapper">
    @include('store.partials.message') <!-- Include message partial here -->        @yield('content')
    </main>

    @include('store.partials.footer')

    @include('store.partials.quickview-modal')

    @stack('scripts')
</body>
</html>
