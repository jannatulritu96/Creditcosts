@if(session()->has('success'))
    <div class="alert alert-primary" role="alert" style="background-color:bisque;color:brown">
        {{ session('success') }}
    </div>
@endif
@if(session()->has('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
@endif