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
            <div class="table-responsive">
                <table class="table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('TAGS_NAME') }}</th>
                            <th>{{ __('TAGS_ITEMS_COUNT') }}</th>
                            <th class="text-center">{{ __('ACTION') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tags as $index => $tag)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="font-semibold">{{ $tag->name }}</span>
                                </td>
                                <td>{{ $tag->items_count }}</td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('tags.show', $tag) }}" class="btn btn-sm btn-outline-info" title="{{ __('TAGS_VIEW') }}">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                        <a href="{{ route('tags.edit', $tag) }}" class="btn btn-sm btn-outline-primary" title="{{ __('TAGS_EDIT') }}">
                                            <i class="ri-pencil-line"></i>
                                        </a>
                                        <form action="{{ route('tags.destroy', $tag) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('TAGS_DELETE_CONFIRM') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger sa-delete" title="{{ __('TAGS_DELETE') }}">
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
        @else
            <div class="alert alert-info">
                {{ __('NO_RESULTS_FOUND') }}
                <p class="mt-2"><a href="{{ route('tags.create') }}" class="underline">{{ __('TAGS_ADD') }}</a></p>
            </div>
        @endif
    </div>
@endsection

@section('js')
@endsection
