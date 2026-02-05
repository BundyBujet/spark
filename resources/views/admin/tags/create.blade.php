@extends('layouts.master')

@section('title')
    {{ env('APP_NAME') }} - {{ __('TAGS_ADD') }}
@endsection

@section('sidebar_section')
tags
@endsection

@section('css')
@endsection

@section('content')
    <x-breadcrumb :items="[
        ['label' => 'DASHBOARD', 'route' => 'admin.dashboard'],
        ['label' => 'TAGS', 'route' => 'tags.index'],
        ['label' => 'TAGS_ADD']
    ]" />
    <div class="panel">
        <h5 class="text-lg font-semibold dark:text-white-light mb-5">{{ __('TAGS_ADD') }}</h5>

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tags.store') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label for="name" class="block text-sm font-semibold mb-2 dark:text-white-light">{{ __('TAGS_NAME') }} <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input @error('name') !border-danger @enderror" placeholder="{{ __('TAGS_NAME') }}" required maxlength="255">
                @error('name')
                    <div class="text-danger mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="ri-save-line mr-1"></i>{{ __('TAGS_SAVE') }}
                </button>
                <a href="{{ route('tags.index') }}" class="btn btn-outline-secondary">{{ __('CANCEL') }}</a>
            </div>
        </form>
    </div>
@endsection

@section('js')
@endsection
