@extends('layouts.master')

@section('title')
    {{ env('APP_NAME') }} - {{ $item->title }}
@endsection

@section('sidebar_section')
    items
@endsection

@section('css')
@endsection

@section('content')
    <x-breadcrumb :items="[
        ['label' => 'DASHBOARD', 'route' => 'admin.dashboard'],
        ['label' => 'ITEMS', 'route' => 'items.index'],
        ['label' => $item->title],
    ]" />
    <div class="panel">
        <h5 class="text-lg font-semibold dark:text-white-light mb-5">{{ $item->title }}</h5>

        <dl class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-5">
            <div>
                <dt class="text-muted">{{ __('ITEMS_TYPE') }}</dt>
                <dd><span class="badge bg-info">{{ ucfirst($item->type) }}</span></dd>
            </div>
            @if ($item->type === 'file')
                <div>
                    <dt class="text-muted">{{ __('TELEGRAM_FILE') }}</dt>
                    <dd>
                        @if ($item->telegramFile)
                            <div  class="flex-col items-center justify-between">
                                {{-- name of the file --}}
                                <div class="mb-2">
                                    <span class="text-muted">{{ __('TELEGRAM_FILE_NAME') }}:</span>
                                    <span class="font-semibold">{{ $item->telegramFile->original_name }}</span>
                                </div>
                                <a href="{{ route('telegram-storage.download', $item->telegramFile) }}"
                                    class="btn btn-primary">
                                    <i class="ri-download-line mr-1"></i>{{ __('TELEGRAM_DOWNLOAD') }}
                                </a>
                            </div>
                        @else
                            <span class="badge bg-danger">{{ __('TELEGRAM_FILE_NOT_FOUND') }}</span>
                        @endif
                    </dd>
                </div>
            @endif
            <div>
                <dt class="text-muted">{{ __('ITEMS_STATUS') }}</dt>
                <dd>
                    @if ($item->status === 'active')
                        <span class="badge bg-success">{{ ucfirst($item->status) }}</span>
                    @elseif ($item->status === 'archived')
                        <span class="badge bg-secondary">{{ ucfirst($item->status) }}</span>
                    @else
                        <span class="badge bg-danger">{{ ucfirst($item->status) }}</span>
                    @endif
                </dd>
            </div>
            <div>
                <dt class="text-muted">{{ __('ITEMS_EXPIRES_AT') }}</dt>
                <dd>
                    @if ($item->expires_at)
                        @if ($item->expires_at->isPast())
                            <span class="text-danger">{{ $item->expires_at->format('Y-m-d H:i') }}
                                ({{ __('ITEMS_EXPIRED') }})</span>
                        @elseif ($item->expires_at->lte(now()->addDays(7)))
                            <span class="text-warning">{{ $item->expires_at->format('Y-m-d H:i') }}
                                ({{ __('ITEMS_EXPIRING_SOON') }})</span>
                        @else
                            {{ $item->expires_at->format('Y-m-d H:i') }}
                        @endif
                    @else
                        -
                    @endif
                </dd>
            </div>
            <div>
                <dt class="text-muted">{{ __('ITEMS_SOURCE') }}</dt>
                <dd>{{ $item->source ? ucfirst($item->source) : '-' }}</dd>
            </div>
        </dl>

        @if ($item->content)
            <div class="mb-5">
                <dt class="text-muted mb-2">{{ __('ITEMS_CONTENT') }}</dt>
                <dd class="whitespace-pre-wrap dark:text-white-light">{{ $item->content }}</dd>
            </div>
        @endif

        <div class="mb-5">
            <dt class="text-muted mb-2">{{ __('ITEMS_TAGS') }}</dt>
            <dd>
                <x-items-tag-display :tags="$item->tags" />
            </dd>
        </div>

        @if ($item->task)
            <div class="mb-5 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                <h6 class="text-sm font-semibold mb-3 dark:text-white-light">{{ __('ITEMS_TASK_FIELDS') }}</h6>
                <dl class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <dt class="text-muted">{{ __('ITEMS_PRIORITY') }}</dt>
                        <dd>{{ ucfirst($item->task->priority) }}</dd>
                    </div>
                    <div>
                        <dt class="text-muted">{{ __('ITEMS_DUE_DATE') }}</dt>
                        <dd>{{ $item->task->due_date?->format('Y-m-d') ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-muted">{{ __('ITEMS_TASK_STATUS') }}</dt>
                        <dd>{{ ucfirst($item->task->task_status) }}</dd>
                    </div>
                </dl>
            </div>
        @endif

        <div class="flex gap-2">
            <a href="{{ route('items.edit', $item) }}" class="btn btn-primary">
                <i class="ri-pencil-line mr-1"></i>{{ __('ITEMS_EDIT') }}
            </a>
            <a href="{{ route('items.index') }}" class="btn btn-outline-secondary">{{ __('CANCEL') }}</a>
        </div>
    </div>
@endsection

@section('js')
@endsection
