@extends('layouts.master')

@section('title')
    {{ env('APP_NAME') }} - {{ __('ITEMS') }}
@endsection

@section('sidebar_section')
items
@endsection

@section('css')
@endsection

@section('content')
    <x-breadcrumb :items="[
        ['label' => 'DASHBOARD', 'route' => 'admin.dashboard'],
        ['label' => 'ITEMS']
    ]" />
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h5 class="text-lg font-semibold dark:text-white-light">{{ __('ITEMS') }}</h5>
            <a href="{{ route('items.create') }}" class="btn btn-sm btn-success">
                <i class="ri-add-line mr-1"></i>{{ __('ITEMS_ADD') }}
            </a>
        </div>

        <form method="GET" action="{{ route('items.index') }}" class="mb-5 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
            <div class="flex flex-wrap items-end gap-3">
                <div>
                    <label for="type" class="block text-sm font-medium mb-1 dark:text-white-light">{{ __('ITEMS_TYPE') }}</label>
                    <select id="type" name="type" class="form-select form-select-sm">
                        <option value="">{{ __('ITEMS_ALL') }}</option>
                        @foreach (\App\Enums\ItemType::cases() as $case)
                            <option value="{{ $case->value }}" @selected(request('type') === $case->value)>{{ ucfirst($case->value) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium mb-1 dark:text-white-light">{{ __('ITEMS_STATUS') }}</label>
                    <select id="status" name="status" class="form-select form-select-sm">
                        <option value="">{{ __('ITEMS_ALL') }}</option>
                        @foreach (\App\Enums\ItemStatus::cases() as $case)
                            <option value="{{ $case->value }}" @selected(request('status') === $case->value)>{{ ucfirst($case->value) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="source" class="block text-sm font-medium mb-1 dark:text-white-light">{{ __('ITEMS_SOURCE') }}</label>
                    <select id="source" name="source" class="form-select form-select-sm">
                        <option value="">{{ __('ITEMS_ALL') }}</option>
                        @foreach (\App\Enums\ItemSource::cases() as $case)
                            <option value="{{ $case->value }}" @selected(request('source') === $case->value)>{{ ucfirst($case->value) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="tag_id" class="block text-sm font-medium mb-1 dark:text-white-light">{{ __('ITEMS_TAG') }}</label>
                    <select id="tag_id" name="tag_id" class="form-select form-select-sm">
                        <option value="">{{ __('ITEMS_ALL') }}</option>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}" @selected(request('tag_id') == $tag->id)>{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <input type="hidden" name="expiring_soon" value="0">
                    <input type="checkbox" id="expiring_soon" name="expiring_soon" value="1" class="form-checkbox" @checked(request('expiring_soon'))>
                    <label for="expiring_soon" class="text-sm dark:text-white-light">{{ __('ITEMS_EXPIRING_SOON') }}</label>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">{{ __('ITEMS_FILTER') }}</button>
                <a href="{{ route('items.index') }}" class="btn btn-sm btn-outline-secondary">{{ __('ITEMS_CLEAR') }}</a>
            </div>
        </form>

        @if (isset($items) && $items->count() > 0)
            <div class="table-responsive">
                <table class="table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('ITEMS_TITLE') }}</th>
                            <th>{{ __('ITEMS_TYPE') }}</th>
                            <th>{{ __('ITEMS_STATUS') }}</th>
                            <th>{{ __('ITEMS_EXPIRES_AT') }}</th>
                            <th>{{ __('ITEMS_SOURCE') }}</th>
                            <th>{{ __('ITEMS_TAGS') }}</th>
                            <th class="text-center">{{ __('ACTION') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = ($items->currentPage() - 1) * $items->perPage() + 1;
                        @endphp
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>
                                    <span class="font-semibold">{{ Str::limit($item->title, 40) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ ucfirst($item->type) }}</span>
                                </td>
                                <td>
                                    @if ($item->status === 'active')
                                        <span class="badge bg-success">{{ ucfirst($item->status) }}</span>
                                    @elseif ($item->status === 'archived')
                                        <span class="badge bg-secondary">{{ ucfirst($item->status) }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ ucfirst($item->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->expires_at)
                                        @if ($item->expires_at->isPast())
                                            <span class="text-danger">{{ $item->expires_at->format('Y-m-d H:i') }} ({{ __('ITEMS_EXPIRED') }})</span>
                                        @elseif ($item->expires_at->lte(now()->addDays(7)))
                                            <span class="text-warning">{{ $item->expires_at->format('Y-m-d H:i') }}</span>
                                        @else
                                            {{ $item->expires_at->format('Y-m-d H:i') }}
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-outline-primary">{{ ucfirst($item->source) }}</span>
                                </td>
                                <td>
                                    @if ($item->tags->isNotEmpty())
                                        {{ $item->tags->pluck('name')->take(2)->implode(', ') }}{{ $item->tags->count() > 2 ? '…' : '' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('items.show', $item) }}" class="btn btn-sm btn-outline-info" title="{{ __('ITEMS_VIEW') }}">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                        <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-outline-primary" title="{{ __('ITEMS_EDIT') }}">
                                            <i class="ri-pencil-line"></i>
                                        </a>
                                        <form action="{{ route('items.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('ITEMS_DELETE_CONFIRM') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger sa-delete" title="{{ __('ITEMS_DELETE') }}">
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
                {{ $items->links() }}
            </div>
        @else
            <div class="alert alert-info">
                {{ __('NO_RESULTS_FOUND') }}
                <p class="mt-2"><a href="{{ route('items.create') }}" class="underline">{{ __('ITEMS_ADD') }}</a></p>
            </div>
        @endif
    </div>
@endsection

@section('js')
@endsection
