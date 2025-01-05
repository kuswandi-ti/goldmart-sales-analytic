@if ($message = Session::get('success'))
    <div class="alert alert-solid-success alert-dismissible fade show">
        {{ $message }}
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-solid-danger alert-dismissible fade show">
        {{ $message }}
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="alert alert-solid-warning alert-dismissible fade show">
        {{ $message }}
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="alert alert-solid-info alert-dismissible fade show">
        {{ $message }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-solid-danger alert-dismissible fade show">
        <strong> Please check the form below for errors</strong>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
    <br>
@endif
