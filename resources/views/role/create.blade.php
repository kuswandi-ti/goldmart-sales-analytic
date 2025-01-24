@extends('layouts.master')

@section('page_title')
    {{ __('Role') }}
@endsection

@section('section_header_title')
    {{ __('Role') }}
@endsection

@section('section_header_breadcrumb')
    @parent
    {{-- <li class="breadcrumb-item">
        <a href="{{ route('role.index') }}" class="text-white-50">
            {{ __('Role') }}
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Menambah Data Role') }}</li> --}}
    <x-breadcrumb-item url="{{ route('role.index') }}" title="{{ __('Role') }}" />
    <x-breadcrumb-active title="{{ __('Menambah Data Role') }}" />
@endsection

@section('page_content')
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <form method="POST" action="{{ route('role.store') }}">
                @csrf

                <div class="card custom-card">
                    <div class="flex-wrap card-header d-flex align-items-center flex-xxl-nowrap">
                        <div class="flex-fill">
                            <div class="card-title">
                                {{ __('Menambah Data Role') }}
                                <p class="subtitle text-muted fs-12 fw-normal">
                                    {{ __('Silahkan input data untuk proses menambah data role') }}
                                </p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('role.index') }}" class="btn btn-warning">
                                {{ __('Kembali') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 row gy-4">
                            <div class="col-xl-12">
                                <label for="role_name" class="form-label text-default">{{ __('Nama Role') }}
                                    <x-all-not-null /></label>
                                <input type="text" class="form-control @error('role_name') is-invalid @enderror"
                                    name="role_name" value="{{ old('role_name') }}" placeholder="{{ __('Nama Role') }}"
                                    autofocus>
                                @error('role_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row gy-4">
                            <div class="col-xl-12">
                                <div id="permission">
                                    <label for="role_name" class="form-label text-default">{{ __('Permission') }}</label>
                                    <div class="accordion accordionicon-left accordions-items-seperate"
                                        id="accordionPanelsStayOpenExample">
                                        @foreach ($permissions as $key => $permission)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                                    <button class="accordion-button" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#{{ Str::slug($key) }}"
                                                        aria-expanded="true" aria-controls="{{ Str::slug($key) }}">
                                                        {{ $key }}
                                                    </button>
                                                </h2>
                                                <div id="{{ Str::slug($key) }}" class="accordion-collapse collapse"
                                                    aria-labelledby="panelsStayOpen-headingOne">
                                                    <div class="accordion-body">
                                                        <div class="mt-1 row gy-1">
                                                            @foreach ($permission->sortBy('name') as $item)
                                                                <div class="col-xl-2">
                                                                    <div class="mb-2 form-check form-switch">
                                                                        <input class="form-check-input"
                                                                            value="{{ $item->name }}" type="checkbox"
                                                                            role="switch" name="permissions[]"
                                                                            id="{{ $item->id }}">
                                                                        <label class="form-check-label"
                                                                            for="{{ $item->id }}">{{ $item->name }}</label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @can('role create')
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Simpan') }}
                            </button>
                        </div>
                    @endcan
                </div>
            </form>
        </div>
    </div>
@endsection
