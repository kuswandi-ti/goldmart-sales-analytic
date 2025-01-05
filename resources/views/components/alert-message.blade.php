@if ($message = Session::get('success'))
    <div class="mb-2 alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
    </div>
    <br>
@endif

@if ($message = Session::get('error'))
    <div class="mb-2 alert alert-danger alert-dismissible fade show" role="alert">
        {{ $message }}
    </div>
    <br>
@endif

@if ($message = Session::get('warning'))
    <div class="mb-2 alert alert-warning alert-dismissible fade show" role="alert">
        {{ $message }}
    </div>
    <br>
@endif

@if ($message = Session::get('info'))
    <div class="mb-2 alert alert-info alert-dismissible fade show" role="alert">
        {{ $message }}
    </div>
    <br>
@endif

@if ($errors->any())
    <div class="mb-2 alert alert-danger alert-dismissible fade show" role="alert">
        <strong> Please check the form below for errors</strong>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
    <br>
@endif
