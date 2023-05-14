@if (session('status-success'))
    <div class="alert alert-success" role="alert">
        {{ session('status-success') }}
    </div>
@endif
@if (session('status-warning'))
    <div class="alert alert-warning" role="alert">
        {{ session('status-warning') }}
    </div>
@endif
@if (session('status-danger'))
    <div class="alert alert-danger" role="alert">
        {{ session('status-danger') }}
    </div>
@endif
