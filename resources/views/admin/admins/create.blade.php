@extends('layouts.master')

@section('title')
    {{ env('APP_NAME') }} - {{ __('title.AddAdmin') }}
@endsection

@section('sidebar_section')
@endsection

@section('css')
@endsection

@section('content')
    <x-breadcrumb :items="[
        ['label' => 'DASHBOARD', 'route' => 'admin.dashboard'],
        ['label' => 'site.Admins', 'route' => 'admins.index'],
        ['label' => 'site.Create']
    ]" />
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0"> {{ __('site.AddNewAdmin') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admins.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name"> {{ __('site.Name') }}<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="basic-default-name"
                                    placeholder="   {{ __('site.Name') }}" value="{{ old('name') }}" />
                            </div>
                        </div>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="username"> {{ __('site.Username') }}<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="username" class="form-control" id="username"
                                    placeholder="   {{ __('site.Username') }}" value="{{ old('username') }}" />
                            </div>
                        </div>
                        @error('username')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="row mb-3 form-password-toggle">
                            <label class="col-sm-2 col-form-label" for="multicol-password"> {{ __('site.Password') }}<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="password" name="password" id="multicol-password" class="form-control"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="multicol-password2" />
                                    <span class="input-group-text cursor-pointer" id="multicol-password2"><i
                                            class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                        </div>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="status"> {{ __('site.Status') }}<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select id="status" name="status" class=" form-select" data-allow-clear="true">
                                    <option value=""> {{ __('site.SelectStatus') }}</option>
                                    <option value="1" @if (old('status') == '1') selected @endif>
                                        {{ __('site.Active') }}</option>
                                    <option value="0" @if (old('status') == '0') selected @endif>
                                        {{ __('site.InActive') }}</option>
                                </select>
                            </div>
                        </div>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="roles"> {{ __('site.Roles') }}<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select id="roles" name="roles[]" class="select2 form-select" data-allow-clear="true"
                                    multiple>
                                    <option value="">{{ __('site.SelectRoles') }}</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}"
                                            @if (old('roles_name') == $role) selected @endif>
                                            {{ $role }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        @error('roles')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">{{ __('site.Add') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection


@section('js')
@endsection
