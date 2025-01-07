@if ($message = Session::get('success'))
    {{-- <div class="alert alert-solid-success alert-dismissible fade show">
        {{ $message }}
    </div> --}}

    <div class="alert custom-alert-two alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i>
        {{ $message }}
    </div>
@endif

@if ($message = Session::get('error'))
    {{-- <div class="alert alert-solid-danger alert-dismissible fade show">
        {{ $message }}
    </div> --}}
    <div class="alert custom-alert-two alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-x-circle"></i>
        {{ $message }}
    </div>
@endif

@if ($message = Session::get('warning'))
    {{-- <div class="alert alert-solid-warning alert-dismissible fade show">
        {{ $message }}
    </div> --}}
    <div class="alert custom-alert-two alert-warning alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle"></i>
        {{ $message }}
    </div>
@endif

@if ($message = Session::get('info'))
    {{-- <div class="alert alert-solid-info alert-dismissible fade show">
        {{ $message }}
    </div> --}}
    <div class="alert custom-alert-two alert-info alert-dismissible fade show" role="alert">
        <i class="bi bi-info-circle"></i>
        {{ $message }}
    </div>
@endif

@if ($errors->any())
    {{-- <div class="alert alert-solid-danger alert-dismissible fade show">
        <strong> {{ __('Please check the form below for errors') }}</strong>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
    <br> --}}

    <div class="alert custom-alert-two alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-x-circle"></i>&nbsp;&nbsp;&nbsp;&nbsp;
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
@endif
