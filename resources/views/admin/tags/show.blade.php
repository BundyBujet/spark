@extends('layouts.master')

@section('title')
    {{ env('APP_NAME') }} - {{ $tag->name }}
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
        ['label' => $tag->name]
    ]" />
    <div class="panel">
        <h5 class="text-lg font-semibold dark:text-white-light mb-5">{{ $tag->name }}</h5>

        <div class="mb-5">
            <dt class="text-muted mb-2">{{ __('TAGS_ITEMS_COUNT') }}</dt>
            <dd>{{ $tag->items->count() }}</dd>
        </div>

        @if ($tag->items->isNotEmpty())
            <div class="mb-5">
                <dt class="text-muted mb-2">{{ __('TAGS_LINKED_ITEMS') }}</dt>
                <dd>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($tag->items as $item)
                            <li>
                                <a href="{{ route('items.show', $item) }}" class="text-primary hover:underline">{{ $item->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </dd>
            </div>
        @endif

        <div class="flex gap-2">
            <a href="{{ route('tags.edit', $tag) }}" class="btn btn-primary">
                <i class="ri-pencil-line mr-1"></i>{{ __('TAGS_EDIT') }}
            </a>
            <a href="{{ route('tags.index') }}" class="btn btn-outline-secondary">{{ __('CANCEL') }}</a>
        </div>
    </div>
@endsection

@section('js')
@endsection
