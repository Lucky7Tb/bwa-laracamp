@if (session('error.message'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ session('error.message') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
