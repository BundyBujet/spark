@extends('layouts.master')

@section('title')
    {{ env('APP_NAME') }} - {{ __('ITEMS') }}
@endsection

@section('sidebar_section')
    items
@endsection

@section('css')
    {{-- Minimal card styles (complements Tailwind, scoped to avoid conflict) --}}
    <style>
        .items-index-card {
            min-height: 225px;
            max-height: 320px;
            /* max-width: 290px; */
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            border-color: rgb(67 97 238 / 0.35);
            box-shadow: 0 10px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            border-color: rgb(67 97 238 / 0.35);
        }

        .items-index-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            border-color: rgb(67 97 238 / 0.35);
        }

        .dark .items-index-card:hover {
            border-color: rgb(67 97 238 / 0.4);
            box-shadow: 0 10px 25px -5px rgb(0 0 0 / 0.25);
        }

        .items-index-card .items-index-action-icon:hover {
            transform: scale(1.1);
        }

        .\32xl\:grid-cols-5{
            grid-template-columns: repeat(5, minmax(0, 1fr));
        }
    </style>
@endsection

@section('content')
    <x-breadcrumb :items="[['label' => 'DASHBOARD', 'route' => 'admin.dashboard'], ['label' => 'ITEMS']]" />
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
                    <label for="type"
                        class="block text-sm font-medium mb-1 dark:text-white-light">{{ __('ITEMS_TYPE') }}</label>
                    <select id="type" name="type" class="form-select form-select-sm">
                        <option value="">{{ __('ITEMS_ALL') }}</option>
                        @foreach (\App\Enums\ItemType::cases() as $case)
                            <option value="{{ $case->value }}" @selected(request('type') === $case->value)>{{ ucfirst($case->value) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status"
                        class="block text-sm font-medium mb-1 dark:text-white-light">{{ __('ITEMS_STATUS') }}</label>
                    <select id="status" name="status" class="form-select form-select-sm">
                        <option value="">{{ __('ITEMS_ALL') }}</option>
                        @foreach (\App\Enums\ItemStatus::cases() as $case)
                            <option value="{{ $case->value }}" @selected(request('status') === $case->value)>{{ ucfirst($case->value) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="source"
                        class="block text-sm font-medium mb-1 dark:text-white-light">{{ __('ITEMS_SOURCE') }}</label>
                    <select id="source" name="source" class="form-select form-select-sm">
                        <option value="">{{ __('ITEMS_ALL') }}</option>
                        @foreach (\App\Enums\ItemSource::cases() as $case)
                            <option value="{{ $case->value }}" @selected(request('source') === $case->value)>{{ ucfirst($case->value) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="tag_id"
                        class="block text-sm font-medium mb-1 dark:text-white-light">{{ __('ITEMS_TAG') }}</label>
                    <select id="tag_id" name="tag_id" class="form-select form-select-sm">
                        <option value="">{{ __('ITEMS_ALL') }}</option>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}" @selected(request('tag_id') == $tag->id)>{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <input type="hidden" name="expiring_soon" value="0">
                    <input type="checkbox" id="expiring_soon" name="expiring_soon" value="1" class="form-checkbox"
                        @checked(request('expiring_soon'))>
                    <label for="expiring_soon"
                        class="text-sm dark:text-white-light">{{ __('ITEMS_EXPIRING_SOON') }}</label>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">{{ __('ITEMS_FILTER') }}</button>
                <a href="{{ route('items.index') }}" class="btn btn-sm btn-outline-secondary">{{ __('ITEMS_CLEAR') }}</a>
            </div>
        </form>

        @if (isset($items) && $items->count() > 0)
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4">
                @foreach ($items as $item)
                    @php
                        $typeIcon = match ($item->type) {
                            'task' => 'ri-checkbox-circle-line',
                            'password' => 'ri-lock-password-line',
                            'note' => 'ri-file-text-line',
                            'idea' => 'ri-lightbulb-line',
                            'link' => 'ri-links-line',
                            'file' => 'ri-file-line',
                            'media' => 'ri-image-line',
                            'reference' => 'ri-bookmark-line',
                            default => 'ri-file-list-3-line',
                        };
                        $tagIcon = $item->tags->isNotEmpty()
                            ? match (true) {
                                str_contains(strtolower($item->tags->first()->name), 'work') => 'ri-briefcase-4-line',
                                str_contains(strtolower($item->tags->first()->name), 'personal') => 'ri-user-line',
                                str_contains(strtolower($item->tags->first()->name), 'important') => 'ri-star-line',
                                str_contains(strtolower($item->tags->first()->name), 'social') => 'ri-team-line',
                                default => 'ri-price-tag-3-line',
                            }
                            : 'ri-file-list-3-line';
                    @endphp
                    <div
                        class="items-index-card relative flex min-h-[280px] max-h-[320px] flex-col overflow-hidden rounded-lg border border-[#e0e6ed] bg-white pb-14 dark:border-[#1b2e4b] dark:bg-[#0e1726]">
                        <div class="flex flex-col min-h-0 flex-1 px-5 py-5">
                            {{-- Header: type icon + type badge + date, 3-dot dropdown --}}
                            <div class="flex w-full items-start justify-between gap-2">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary dark:bg-primary/20">
                                        <i class="text-lg {{ $typeIcon }}"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="badge bg-info w-fit text-xs">{{ ucfirst($item->type) }}</span>
                                        <span
                                            class="mt-1 block text-xs text-white-dark dark:text-white-dark">{{ $item->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                                <div class="dropdown shrink-0" x-data="dropdown" @click.outside="open = false">
                                    <button type="button"
                                        class="rounded-md p-1.5 text-white-dark opacity-70 transition-opacity hover:opacity-100 hover:bg-white-dark/10 dark:hover:bg-[#181F32]"
                                        @click="toggle">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" class="rotate-90">
                                            <circle cx="5" cy="12" r="2" stroke="currentColor"
                                                stroke-width="1.5"></circle>
                                            <circle cx="12" cy="12" r="2" stroke="currentColor"
                                                stroke-width="1.5" opacity="0.5"></circle>
                                            <circle cx="19" cy="12" r="2" stroke="currentColor"
                                                stroke-width="1.5"></circle>
                                        </svg>
                                    </button>
                                    <ul x-cloak x-show="open" x-transition x-transition.duration.300ms
                                        class="absolute top-full z-10 mt-1 min-w-[140px] rounded-lg border border-[#e0e6ed] bg-white py-1 shadow-lg dark:border-[#1b2e4b] dark:bg-[#0e1726] ltr:right-0 rtl:left-0">
                                        <li>
                                            <a href="{{ route('items.show', $item) }}"
                                                class="flex items-center px-4 py-2 text-sm transition-colors hover:bg-white-dark/10 dark:hover:bg-[#181F32]">
                                                <i class="ri-eye-line ltr:mr-3 rtl:ml-3"></i>{{ __('ITEMS_VIEW') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('items.edit', $item) }}"
                                                class="flex items-center px-4 py-2 text-sm transition-colors hover:bg-white-dark/10 dark:hover:bg-[#181F32]">
                                                <i class="ri-pencil-line ltr:mr-3 rtl:ml-3"></i>{{ __('ITEMS_EDIT') }}
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('items.destroy', $item) }}" method="POST"
                                                class="block"
                                                onsubmit="return confirm('{{ __('ITEMS_DELETE_CONFIRM') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="flex w-full items-center px-4 py-2 text-sm text-danger transition-colors hover:bg-white-dark/10 dark:hover:bg-[#181F32]">
                                                    <i
                                                        class="ri-delete-bin-line ltr:mr-3 rtl:ml-3"></i>{{ __('ITEMS_DELETE') }}
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            {{-- Content: title + description (line-clamp) --}}
                            <div class="mt-4 flex min-h-0 flex-1 flex-col">
                                <h4 class="line-clamp-2 overflow-hidden font-semibold text-dark dark:text-white-light">
                                    {{ $item->title }}</h4>
                                <p class="break-all mt-2 min-h-0 flex-1 text-sm text-white-dark">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($item->content ?? ''), 100, '...') }}
                                </p>
                            </div>
                        </div>
                        {{-- Footer: tag name + action icons (icon-only) --}}
                        <div
                            class=" bottom-0 left-0 w-full border-t border-[#e0e6ed] bg-white px-5 py-3 dark:border-[#1b2e4b] dark:bg-[#0e1726]">
                            <div class="flex items-center justify-between">
                                <div class="flex min-w-0 items-center text-white-dark">
                                    @if ($item->tags->isNotEmpty())
                                        <i
                                            class="{{ $tagIcon }} h-3.5 w-3.5 shrink-0 opacity-70 ltr:mr-1.5 rtl:ml-1.5"></i>
                                        <span class="truncate text-xs">{{ $item->tags->first()->name }}</span>
                                    @else
                                        <i
                                            class="ri-file-list-3-line h-3.5 w-3.5 shrink-0 opacity-50 ltr:mr-1.5 rtl:ml-1.5"></i>
                                        <span class="text-xs">—</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-0.5">
                                    <a href="{{ route('items.show', $item) }}"
                                        class="items-index-action-icon inline-flex h-8 w-8 items-center justify-center rounded-md text-white-dark transition-transform duration-150 hover:bg-info/10 hover:text-info"
                                        title="{{ __('ITEMS_VIEW') }}">
                                        <i class="ri-eye-line text-lg"></i>
                                    </a>
                                    <a href="{{ route('items.edit', $item) }}"
                                        class="items-index-action-icon inline-flex h-8 w-8 items-center justify-center rounded-md text-white-dark transition-transform duration-150 hover:bg-primary/10 hover:text-primary"
                                        title="{{ __('ITEMS_EDIT') }}">
                                        <i class="ri-pencil-line text-lg"></i>
                                    </a>
                                    <form action="{{ route('items.destroy', $item) }}" method="POST" class="inline"
                                        onsubmit="return confirm('{{ __('ITEMS_DELETE_CONFIRM') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="items-index-action-icon sa-delete inline-flex h-8 w-8 items-center justify-center rounded-md text-white-dark transition-transform duration-150 hover:bg-danger/10 hover:text-danger"
                                            title="{{ __('ITEMS_DELETE') }}">
                                            <i class="ri-delete-bin-line text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $items->links('components.pagination') }}
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
