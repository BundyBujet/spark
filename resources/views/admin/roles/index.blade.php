@extends('layouts.master')

@section('title')
    {{ env('APP_NAME') }} - {{ __('ROLES') }}
@endsection

@section('sidebar_section')
roles
@endsection

@section('css')
@endsection

@section('content')
    <x-breadcrumb :items="[
        ['label' => 'DASHBOARD', 'route' => 'admin.dashboard'],
        ['label' => 'ROLES']
    ]" />
    <div class="panel">
        <div class="flex items-center justify-between mb-5">
            <h5 class="text-lg font-semibold dark:text-white-light">{{ __('ROLES') }}</h5>
            @can('Add Role')
                <a href="{{ route('roles.create') }}" class="btn btn-sm btn-success">
                    <i class="ri-add-line mr-1"></i>{{ __('ADD_ROLE') }}
                </a>
            @endcan
        </div>

        @if (isset($roles) && count($roles) > 0)
            <div class="table-responsive">
                <table class="table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('ROLE_NAME') }}</th>
                            <th>{{ __('PERMISSIONS') }}</th>
                            <th class="text-center">{{ __('ACTION') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = ($roles->currentPage() - 1) * $roles->perPage() + 1;
                        @endphp
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>
                                    <span class="font-semibold">{{ $role->name }}</span>
                                    @if (auth()->user()->hasRole($role->name))
                                        <span class="badge bg-success ml-2">{{ __('site.You') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $role->permissions->count() }} {{ __('PERMISSIONS') }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @can('Show Role')
                                            <a href="{{ route('roles.show', $role->id) }}" class="btn btn-sm btn-info">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                        @endcan
                                        @can('Edit Role')
                                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-primary">
                                                <i class="ri-pencil-line"></i>
                                            </a>
                                        @endcan
                                        @can('Delete Role')
                                            @if (!auth()->user()->hasRole($role->name))
                                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger sa-delete">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $roles->links() }}
            </div>
        @else
            <div class="alert alert-danger">
                {{ __('NO_RESULTS_FOUND') }}
            </div>
        @endif
    </div>
@endsection

@section('js')
@endsection
