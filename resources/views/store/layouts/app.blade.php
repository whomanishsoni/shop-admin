<!DOCTYPE html>
<html lang="en">
<head>
    @include('store.partials.head')

    {{-- ✅ GLOBAL MESSAGE FUNCTION - LOADS FIRST! --}}
    <script>
        window.showGlobalMessage = function(message, type) {
            // Remove existing messages first
            document.querySelectorAll('.alert-custom-position').forEach(el => el.remove());

            const messageDiv = document.createElement('div');
            messageDiv.className = `alert alert-${type} alert-dismissible fade show alert-custom-position`;
            messageDiv.setAttribute('role', 'alert');
            messageDiv.innerHTML = `
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            `;

            // Insert at the very top
            document.body.insertBefore(messageDiv, document.body.firstChild);

            // Auto-dismiss after 4 seconds
            setTimeout(() => {
                messageDiv.classList.remove('show');
                messageDiv.classList.add('fade');
                setTimeout(() => messageDiv.remove(), 150);
            }, 4000);
        };
    </script>
</head>
<body>
    <div id="preloader" class="preloader">
        <div class="loader"></div>
    </div>
    @include('store.partials.header')

    <main class="main__content_wrapper">
        @include('store.partials.message')
        @yield('content')
    </main>

    @include('store.partials.footer')
    @include('store.partials.quickview-modal')

    @stack('scripts')
</body>
</html>
