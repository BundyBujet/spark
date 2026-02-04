@extends('layouts.master')

@section('title')
    {{ env('APP_NAME') }} - {{ __('TELEGRAM_STORAGE') }}
@endsection

@section('sidebar_section')
telegram-storage
@endsection

@section('css')
@endsection

@section('content')
    <x-breadcrumb :items="[
        ['label' => 'DASHBOARD', 'route' => 'admin.dashboard'],
        ['label' => 'TELEGRAM_STORAGE']
    ]" />
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h5 class="text-lg font-semibold dark:text-white-light">{{ __('TELEGRAM_STORAGE') }}</h5>
            <a href="{{ route('telegram-storage.create') }}" class="btn btn-sm btn-success">
                <i class="ri-upload-cloud-line mr-1"></i>{{ __('TELEGRAM_STORAGE_UPLOAD') }}
            </a>
        </div>

        @if (isset($telegramFiles) && $telegramFiles->count() > 0)
            <div class="table-responsive">
                <table class="table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('TELEGRAM_FILE_NAME') }}</th>
                            <th>{{ __('TELEGRAM_SIZE') }}</th>
                            <th>{{ __('TELEGRAM_TYPE') }}</th>
                            <th>{{ __('TELEGRAM_SOURCE') }}</th>
                            <th>{{ __('TELEGRAM_DATE') }}</th>
                            <th class="text-center">{{ __('ACTION') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = ($telegramFiles->currentPage() - 1) * $telegramFiles->perPage() + 1;
                        @endphp
                        @foreach ($telegramFiles as $file)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>
                                    <span class="font-semibold">{{ Str::limit($file->original_name, 40) }}</span>
                                </td>
                                <td>
                                    @if ($file->size)
                                        {{ number_format($file->size / 1024, 1) }} KB
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $file->type ?? 'document' }}</span>
                                </td>
                                <td>
                                    @if ($file->source === 'web')
                                        <span class="badge bg-primary">{{ __('TELEGRAM_SOURCE_WEB') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ __('TELEGRAM_SOURCE_TELEGRAM') }}</span>
                                    @endif
                                </td>
                                <td>{{ $file->created_at?->format('Y-m-d H:i') }}</td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('telegram-storage.download', $file) }}" class="btn btn-sm btn-info" target="_blank" rel="noopener">
                                            <i class="ri-download-line"></i>
                                        </a>
                                        <form action="{{ route('telegram-storage.destroy', $file) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger sa-delete">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $telegramFiles->links() }}
            </div>
        @else
            <div class="alert alert-info">
                {{ __('NO_RESULTS_FOUND') }}
                <p class="mt-2">{{ __('TELEGRAM_STORAGE_UPLOAD') }} {{ __('TELEGRAM_GET_CHANNEL_ID') }}</p>
            </div>
        @endif
    </div>
@endsection

@section('js')
@endsection
