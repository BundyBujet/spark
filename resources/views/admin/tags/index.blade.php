@extends('layouts.master')

@section('title')
    {{ env('APP_NAME') }} - {{ __('TAGS') }}
@endsection

@section('sidebar_section')
    tags
@endsection

@section('css')
@endsection

@section('content')
    <x-breadcrumb :items="[
        ['label' => 'DASHBOARD', 'route' => 'admin.dashboard'],
        ['label' => 'TAGS']
    ]" />

    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h5 class="text-lg font-semibold dark:text-white-light">{{ __('TAGS') }}</h5>
            <a href="{{ route('tags.create') }}" class="btn btn-sm btn-success">
                <i class="ri-add-line mr-1"></i>{{ __('TAGS_ADD') }}
            </a>
        </div>

        @if (isset($tags) && $tags->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($tags as $index => $tag)
                    <div class="panel p-5 hover:shadow-lg transition-shadow duration-200 dark:bg-dark dark:border-dark-foreground/20">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h6 class="font-semibold text-base dark:text-white-light">
                                    {{ $tag->name }}
                                </h6>
                                
                            </div>

                            <span class="badge bg-info/20 text-info dark:bg-info/30 dark:text-info-light px-2.5 py-1 rounded-full text-xs font-medium">
                                {{ $tag->items_count }} {{ Str::plural(__('item'), $tag->items_count) }}
                            </span>
                        </div>

                        <div class="flex items-center justify-end gap-2 mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('tags.show', $tag) }}" 
                               class="btn btn-sm btn-outline-info" 
                               title="{{ __('TAGS_VIEW') }}">
                                <i class="ri-eye-line"></i>
                            </a>

                            <a href="{{ route('tags.edit', $tag) }}" 
                               class="btn btn-sm btn-outline-primary" 
                               title="{{ __('TAGS_EDIT') }}">
                                <i class="ri-pencil-line"></i>
                            </a>

                            <form action="{{ route('tags.destroy', $tag) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('{{ __('TAGS_DELETE_CONFIRM') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-sm btn-danger sa-delete" 
                                        title="{{ __('TAGS_DELETE') }}">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="panel text-center py-12">
                <div class="text-5xl text-gray-300 dark:text-gray-600 mb-4">
                    <i class="ri-price-tag-3-line"></i>
                </div>
                <p class="text-lg font-semibold dark:text-white-light mb-2">
                    {{ __('NO_RESULTS_FOUND') }}
                </p>
                <p class="text-gray-500 dark:text-gray-400 mb-6">
                    {{ __('Start organizing your content with tags.') }}
                </p>
                <a href="{{ route('tags.create') }}" class="btn btn-sm btn-success">
                    <i class="ri-add-line mr-1"></i>{{ __('TAGS_ADD') }}
                </a>
            </div>
        @endif
    </div>
@endsection

@section('js')
@endsection