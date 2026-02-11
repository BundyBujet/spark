@extends('layouts.master')

@section('title')
    {{ env('APP_NAME') }} - {{ __('ITEMS_EDIT') }} - {{ $item->title }}
@endsection

@section('sidebar_section')
    items
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href={{ asset('assets/css/nice-select2.css') }} />
@endsection

@section('content')
    <x-breadcrumb :items="[
        ['label' => 'DASHBOARD', 'route' => 'admin.dashboard'],
        ['label' => 'ITEMS', 'route' => 'items.index'],
        ['label' => 'ITEMS_EDIT'],
    ]" />
    <div class="panel" x-data="{ itemType: '{{ old('type', $item->type) }}' }">
        <h5 class="text-lg font-semibold dark:text-white-light mb-5">{{ __('ITEMS_EDIT') }}: {{ $item->title }}</h5>

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('items.update', $item) }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label for="title"
                            class="block text-sm font-semibold mb-2 dark:text-white-light">{{ __('ITEMS_TITLE') }} <span
                                class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $item->title) }}"
                            class="form-input @error('title') !border-danger @enderror"
                            placeholder="{{ __('ITEMS_TITLE') }}" required maxlength="255">
                        @error('title')
                            <div class="text-danger mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="type"
                            class="block text-sm font-semibold mb-2 dark:text-white-light">{{ __('ITEMS_TYPE') }} <span
                                class="text-danger">*</span></label>
                        <select id="type" name="type" x-model="itemType" required
                            class="form-input @error('type') !border-danger @enderror">
                            @foreach (\App\Enums\ItemType::cases() as $case)
                                <option value="{{ $case->value }}" @selected(old('type', $item->type) === $case->value)>
                                    {{ ucfirst($case->value) }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <div class="text-danger mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div x-show="itemType === 'task'" x-cloak
                    class="panel mt-5 mb-5 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                    <h6 class="text-sm font-semibold mb-3 dark:text-white-light">{{ __('ITEMS_TASK_FIELDS') }}</h6>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label for="priority"
                                class="block text-sm font-semibold mb-2 dark:text-white-light">{{ __('ITEMS_PRIORITY') }}</label>
                            <select id="priority" name="priority" class="form-input">
                                @foreach (\App\Enums\TaskPriority::cases() as $case)
                                    <option value="{{ $case->value }}" @selected(old('priority', $item->task?->priority ?? 'normal') === $case->value)>
                                        {{ ucfirst($case->value) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="due_date"
                                class="block text-sm font-semibold mb-2 dark:text-white-light">{{ __('ITEMS_DUE_DATE') }}</label>
                            <input type="date" id="due_date" name="due_date"
                                value="{{ old('due_date', $item->task?->due_date?->format('Y-m-d')) }}" class="form-input">
                        </div>
                        <div>
                            <label for="task_status"
                                class="block text-sm font-semibold mb-2 dark:text-white-light">{{ __('ITEMS_TASK_STATUS') }}</label>
                            <select id="task_status" name="task_status" class="form-input">
                                @foreach (\App\Enums\TaskStatus::cases() as $case)
                                    <option value="{{ $case->value }}" @selected(old('task_status', $item->task?->task_status ?? 'todo') === $case->value)>
                                        {{ ucfirst($case->value) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div x-show="itemType === 'file'" x-cloak
                    class="panel mt-5 mb-5 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                    <h6 class="text-sm font-semibold mb-3 dark:text-white-light"></h6>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label for="telegram_file_id"
                                class="block text-sm font-semibold mb-2 dark:text-white-light">{{ __('TELEGRAM_FILE') }}</label>
                            <select id="telegram_file_id" name="telegram_file_id">
                                <option value="">{{ __('TELEGRAM_FILE_REQUIRED') }}</option>
                                @foreach ($telegramFiles as $file)
                                    <option value="{{ $file->id }}" @selected(old('telegram_file_id', $file->telegram_file_id) === $file->id) {{ $file->id === $item->telegram_file_id ? 'selected' : '' }}>
                                        {{ $file->original_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                <div class="mb-5">
                    <label for="content"
                        class="block text-sm font-semibold mb-2 dark:text-white-light">{{ __('ITEMS_CONTENT') }}</label>
                    <textarea id="content" name="content" rows="4" class="form-input @error('content') !border-danger @enderror"
                        placeholder="{{ __('ITEMS_CONTENT') }}">{{ old('content', $item->content) }}</textarea>
                    @error('content')
                        <div class="text-danger mt-1 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label for="expires_at"
                            class="block text-sm font-semibold mb-2 dark:text-white-light">{{ __('ITEMS_EXPIRES_AT') }}</label>
                        <input type="datetime-local" id="expires_at" name="expires_at"
                            value="{{ old('expires_at', $item->expires_at?->format('Y-m-d\TH:i')) }}"
                            class="form-input @error('expires_at') !border-danger @enderror">
                        @error('expires_at')
                            <div class="text-danger mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <x-items-tag-selector
                            :tags="$tags"
                            :selected-ids="old('tags', $item->tags->pluck('id')->toArray())"
                            name="tags"
                            :error="$errors->first('tags')" />
                    </div>
                </div>
            </div>
            <div class="flex gap-2 mt-5">
                <button type="submit" class="btn btn-success">
                    <i class="ri-save-line mr-1"></i>{{ __('ITEMS_SAVE') }}
                </button>
                <a href="{{ route('items.index') }}" class="btn btn-outline-secondary">{{ __('CANCEL') }}</a>
                <a href="{{ route('items.show', $item) }}" class="btn btn-outline-info">{{ __('ITEMS_VIEW') }}</a>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script src={{ asset('assets/js/nice-select2.js') }}></script>

    <script>
        document.addEventListener("DOMContentLoaded", function(e) {
            // seachable
            var options = {
                searchable: true
            };
            NiceSelect.bind(document.getElementById("telegram_file_id"), options);

        });
    </script>
@endsection
