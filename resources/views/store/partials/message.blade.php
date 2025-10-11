<style>
    .alert-custom-position {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
        max-width: 300px; /* Optional: Limit width for better appearance */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Optional: Add shadow for elevation */
    }
</style>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show alert-custom-position" role="alert" id="success-alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show alert-custom-position" role="alert" id="error-alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@push('scripts')
    <script>
        // Ensure DOM is ready before running the script
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-dismiss success alert after 4 seconds
            setTimeout(function() {
                var successAlert = document.getElementById('success-alert');
                if (successAlert) {
                    successAlert.classList.remove('show');
                    successAlert.classList.add('fade');
                    setTimeout(() => successAlert.style.display = 'none', 150); // Fade out animation
                }
            }, 4000);

            // Auto-dismiss error alert after 4 seconds
            setTimeout(function() {
                var errorAlert = document.getElementById('error-alert');
                if (errorAlert) {
                    errorAlert.classList.remove('show');
                    errorAlert.classList.add('fade');
                    setTimeout(() => errorAlert.style.display = 'none', 150); // Fade out animation
                }
            }, 4000);
        });
    </script>
@endpush
