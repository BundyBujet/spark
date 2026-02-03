@extends('layouts.master')

@section('title')
    {{ env('APP_NAME') }} - {{ __('title.Admins') }}
@endsection

@section('sidebar_section')
@endsection

@section('css')
@endsection

@section('content')
    <x-breadcrumb :items="[
        ['label' => 'DASHBOARD', 'route' => 'admin.dashboard'],
        ['label' => 'site.Admins']
    ]" />
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session()->has('Add'))
            <div class="alert alert-success" role="alert">{{ session()->get('Add') }}</div>
        @endif
        @if (session()->has('Update'))
            <div class="alert alert-primary" role="alert">{{ session()->get('Update') }}</div>
        @endif
        @if (session()->has('Delete'))
            <div class="alert alert-danger" role="alert">{{ session()->get('Delete') }}</div>
        @endif
        @if (session()->has('Warning'))
            <div class="alert alert-warning" role="alert">{{ session()->get('Warning') }}</div>
        @endif
        <div class="card">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-header">{{ __('site.Admins') }}</h5>
                @can('Add Admin')
                    <a href="{{ route('admins.create') }}" class="btn btn-sm btn-success m-2">
                        {{ __('site.Add') }}
                    </a>
                @endcan

            </div>
            <div class="table-responsive text-nowrap">
                <input type="hidden" id="ajax_search_url" value="{{ route('admins.ajax_search') }}">
                <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                <div class="col-md-6 p-2">
                    <input type="text" id="search_by_text" placeholder="{{ __('site.SearchByName') }}"
                        class="form-control">
                    <br />
                </div>
                <div id="ajax_search_table">
                    @if (@isset($admins) && count($admins) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('site.Name') }}</th>
                                    <th>{{ __('site.Username') }}</th>
                                    <th>{{ __('site.Status') }}</th>
                                    <th>{{ __('site.Phone') }}</th>
                                    <th>{{ __('site.More') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($admins as $admin)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            {{ $admin->name }}
                                            @if (auth()->user()->id == $admin->id)
                                                <span class="badge bg-gray"> {{ __('site.You') }}</span>
                                            @endif
                                        </td>
                                        <td> {{ $admin->username }}</td>
                                        <td>
                                            @if ($admin->status == 1)
                                                <span class="badge bg-success">{{ __('site.Active') }}</span>
                                            @else
                                                <span class="badge bg-danger">معطل{{ __('site.InActive') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $admin->phone ?? 'ـــــــــ' }}</td>

                                        <td class="text-center d-flex">
                                            @can('Edit Admin')
                                                <a href="{{ route('admins.edit', $admin->id) }}"
                                                    class="btn btn-sm btn-info me-2">
                                                    <i class="fa fa-edit"></i> {{ __('site.Edit') }}
                                                </a>
                                            @endcan
                                            @can('Delete Admin')
                                                @if (auth()->user()->id !== $admin->id)
                                                    <form id="user-delete-{{ $admin->id }}"
                                                        action="{{ route('admins.destroy', $admin->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger sa-delete me-2">
                                                            <i class="fa fa-trash"></i> {{ __('site.Delete') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            @endcan


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br />
                        {{ $admins->links() }}
                    @else
                        <div class="alert alert-danger">
                            {{ __('site.NoDataFound') }}

                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection


@section('js')
    <script src="{{ asset('assets/javascript/admins.js') }}"></script>
@endsection
