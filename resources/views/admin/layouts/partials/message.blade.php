<div class="position-fixed" style="top: 60px; right: 20px; z-index: 1000; max-width: 300px;">
    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" id="successMessage" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Error Message -->
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" id="errorMessage" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" id="validationErrors" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</div>

<script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
    function hideAndRemove(elementId) {
        setTimeout(() => {
            const element = document.getElementById(elementId);
            if (element) {
                element.classList.remove('show');
                element.classList.add('fade');
                setTimeout(() => {
                    element.style.display = 'none';
                }, 500);
            }
        }, 4000);
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (document.getElementById('successMessage')) {
            hideAndRemove('successMessage');
        }
        if (document.getElementById('errorMessage')) {
            hideAndRemove('errorMessage');
        }
        if (document.getElementById('validationErrors')) {
            hideAndRemove('validationErrors');
        }
    });
</script>
