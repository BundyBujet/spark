@extends('layouts.master')

@section('title')
    {{ env('APP_NAME') }} - {{ __('TASKS') }}
@endsection

@section('sidebar_section')
tasks
@endsection

@section('css')
@endsection

@section('content')
    <x-breadcrumb :items="[
        ['label' => 'DASHBOARD', 'route' => 'admin.dashboard'],
        ['label' => 'TASKS']
    ]" />
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h5 class="text-lg font-semibold dark:text-white-light">{{ __('TASKS') }}</h5>
            <a href="{{ route('items.create') }}?type=task" class="btn btn-sm btn-success">
                <i class="ri-add-line mr-1"></i>{{ __('TASKS_ADD_ITEM') }}
            </a>
        </div>

        <form method="GET" action="{{ route('tasks.index') }}" class="mb-5 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
            <div class="flex flex-wrap items-end gap-3">
                <div>
                    <label for="priority" class="block text-sm font-medium mb-1 dark:text-white-light">{{ __('TASKS_PRIORITY') }}</label>
                    <select id="priority" name="priority" class="form-select form-select-sm">
                        <option value="">{{ __('ITEMS_ALL') }}</option>
                        @foreach (\App\Enums\TaskPriority::cases() as $case)
                            <option value="{{ $case->value }}" @selected(request('priority') === $case->value)>{{ ucfirst($case->value) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="task_status" class="block text-sm font-medium mb-1 dark:text-white-light">{{ __('TASKS_STATUS') }}</label>
                    <select id="task_status" name="task_status" class="form-select form-select-sm">
                        <option value="">{{ __('ITEMS_ALL') }}</option>
                        @foreach (\App\Enums\TaskStatus::cases() as $case)
                            <option value="{{ $case->value }}" @selected(request('task_status') === $case->value)>{{ ucfirst($case->value) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="due_from" class="block text-sm font-medium mb-1 dark:text-white-light">{{ __('TASKS_DUE_FROM') }}</label>
                    <input type="date" id="due_from" name="due_from" value="{{ request('due_from') }}" class="form-input form-input-sm">
                </div>
                <div>
                    <label for="due_to" class="block text-sm font-medium mb-1 dark:text-white-light">{{ __('TASKS_DUE_TO') }}</label>
                    <input type="date" id="due_to" name="due_to" value="{{ request('due_to') }}" class="form-input form-input-sm">
                </div>
                <button type="submit" class="btn btn-sm btn-primary">{{ __('ITEMS_FILTER') }}</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-outline-secondary">{{ __('ITEMS_CLEAR') }}</a>
            </div>
        </form>

        @if (isset($items) && $items->count() > 0)
            <div class="table-responsive">
                <table class="table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('TASKS_ITEM') }}</th>
                            <th>{{ __('TASKS_PRIORITY') }}</th>
                            <th>{{ __('TASKS_DUE_DATE') }}</th>
                            <th>{{ __('TASKS_STATUS') }}</th>
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
                                    <a href="{{ route('items.show', $item) }}" class="font-semibold text-primary hover:underline">{{ Str::limit($item->title, 40) }}</a>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $item->task ? ucfirst($item->task->priority) : '-' }}</span>
                                </td>
                                <td>{{ $item->task?->due_date?->format('Y-m-d') ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-outline-primary">{{ $item->task ? ucfirst($item->task->task_status) : '-' }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('items.show', $item) }}" class="btn btn-sm btn-outline-info" title="{{ __('ITEMS_VIEW') }}">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                        <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-outline-primary" title="{{ __('ITEMS_EDIT') }}">
                                            <i class="ri-pencil-line"></i>
                                        </a>
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
                {{ __('TASKS_NO_RESULTS') }}
                <p class="mt-2"><a href="{{ route('items.create') }}?type=task" class="underline">{{ __('TASKS_ADD_ITEM') }}</a></p>
            </div>
        @endif
    </div>
@endsection

@section('js')
@endsection
