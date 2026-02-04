@extends('layouts.master')

@section('title')
    {{ env('APP_NAME') }} - {{ __('TELEGRAM_STORAGE_UPLOAD') }}
@endsection

@section('sidebar_section')
telegram-storage
@endsection

@section('css')
@endsection

@section('content')
    <x-breadcrumb :items="[
        ['label' => 'DASHBOARD', 'route' => 'admin.dashboard'],
        ['label' => 'TELEGRAM_STORAGE', 'route' => 'telegram-storage.index'],
        ['label' => 'TELEGRAM_STORAGE_UPLOAD']
    ]" />
    <div class="panel">
        <h5 class="text-lg font-semibold dark:text-white-light mb-5">{{ __('TELEGRAM_STORAGE_UPLOAD') }}</h5>

        <form action="{{ route('telegram-storage.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <div>
                    <label for="file">{{ __('TELEGRAM_FILE_NAME') }}</label>
                    <input id="file" name="file" type="file" class="form-input file:py-2 file:px-4 file:border-0 file:font-semibold p-0 file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white file:hover:bg-primary" required />
                </div>
                @error('file')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
                <p class="text-muted text-sm mt-1">{{ __('TELEGRAM_FILE_TOO_LARGE') }} (max 2 GB)</p>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="ri-upload-cloud-line mr-1"></i>{{ __('TELEGRAM_STORAGE_UPLOAD') }}
                </button>
                <a href="{{ route('telegram-storage.index') }}" class="btn btn-outline-secondary">{{ __('CANCEL') }}</a>
            </div>
        </form>
    </div>
@endsection

@section('js')
@endsection
