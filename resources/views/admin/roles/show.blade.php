@extends('layouts.master')

@section('title')
    {{ env('APP_NAME') }} - {{ __('ROLE_DETAILS') }} - {{ $role->name }}
@endsection

@section('sidebar_section')
roles
@endsection

@section('css')
@endsection

@section('content')
    <x-breadcrumb :items="[
        ['label' => 'DASHBOARD', 'route' => 'admin.dashboard'],
        ['label' => 'ROLES', 'route' => 'roles.index'],
        ['label' => 'ROLE_DETAILS']
    ]" />
    <div class="panel">

        <div class="grid grid-cols-1 gap-5">
            <div>
                <label class="block text-sm font-semibold mb-2 dark:text-white-light">
                    {{ __('ROLE_NAME') }}
                </label>
                <div class="text-lg font-medium dark:text-white-light">{{ $role->name }}</div>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2 dark:text-white-light">
                    {{ __('PERMISSIONS') }}
                </label>
                @if (!empty($rolePermissions) && count($rolePermissions) > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach ($rolePermissions as $permission)
                            <span class="badge bg-success">{{ $permission->name }}</span>
                        @endforeach
                    </div>
                @else
                    <div class="text-muted">{{ __('NO_RESULTS_FOUND') }}</div>
                @endif
            </div>
        </div>

        <div class="flex items-center justify-start gap-3 mt-5">
            <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
                {{ __('CANCEL') }}
            </a>
            @can('Edit Role')
                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary">
                    {{ __('site.Edit') }}
                </a>
            @endcan
        </div>
    </div>
@endsection

@section('js')
@endsection
