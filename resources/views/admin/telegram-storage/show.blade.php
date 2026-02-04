@extends('layouts.master')

@section('title')
    {{ env('APP_NAME') }} - {{ $telegramFile->original_name }}
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
        ['label' => $telegramFile->original_name]
    ]" />
    <div class="panel">
        <h5 class="text-lg font-semibold dark:text-white-light mb-5">{{ __('TELEGRAM_FILE_NAME') }}: {{ $telegramFile->original_name }}</h5>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div><dt class="text-muted">{{ __('TELEGRAM_SIZE') }}</dt><dd>{{ $telegramFile->size ? number_format($telegramFile->size / 1024, 1) . ' KB' : '-' }}</dd></div>
            <div><dt class="text-muted">{{ __('TELEGRAM_TYPE') }}</dt><dd>{{ $telegramFile->type ?? 'document' }}</dd></div>
            <div><dt class="text-muted">{{ __('TELEGRAM_SOURCE') }}</dt><dd>{{ $telegramFile->source === 'web' ? __('TELEGRAM_SOURCE_WEB') : __('TELEGRAM_SOURCE_TELEGRAM') }}</dd></div>
            <div><dt class="text-muted">{{ __('TELEGRAM_DATE') }}</dt><dd>{{ $telegramFile->created_at?->format('Y-m-d H:i') }}</dd></div>
        </dl>
        <div class="mt-4 flex gap-2">
            <a href="{{ route('telegram-storage.download', $telegramFile) }}" class="btn btn-info" target="_blank" rel="noopener">
                <i class="ri-download-line mr-1"></i>{{ __('TELEGRAM_DOWNLOAD') }}
            </a>
            <a href="{{ route('telegram-storage.index') }}" class="btn btn-outline-secondary">{{ __('CANCEL') }}</a>
        </div>
    </div>
@endsection

@section('js')
@endsection
