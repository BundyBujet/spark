@extends('layouts.master')

@section('title')
    {{ env('APP_NAME') }} - {{ __('site.Edit') }} - {{ $role->name }}
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
        ['label' => 'site.Edit']
    ]" />
    <div class="panel">

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-5">
                <label for="name" class="block text-sm font-semibold mb-2 dark:text-white-light">
                    {{ __('ROLE_NAME') }} <span class="text-danger">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $role->name) }}"
                    class="form-input @error('name') !border-danger @enderror"
                    placeholder="{{ __('ROLE_NAME') }}" required>
                @error('name')
                    <div class="text-danger mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2 dark:text-white-light">
                    {{ __('PERMISSIONS') }} <span class="text-danger">*</span>
                </label>
                <div class="mb-3">
                    <label class="inline-flex items-center cursor-pointer gap-2">
                        <label class="w-12 h-6 relative">
                            <input type="checkbox" class="custom_switch absolute w-full h-full opacity-0 z-10 cursor-pointer peer" id="selectAll" x-data
                                @change="$el.checked ? document.querySelectorAll('.permission-switch').forEach(cb => cb.checked = true) : document.querySelectorAll('.permission-switch').forEach(cb => cb.checked = false)">
                            <span for="selectAll" class="bg-[#ebedf2] dark:bg-dark block h-full rounded-full before:absolute before:left-1 before:bg-white dark:before:bg-white-dark dark:peer-checked:before:bg-white before:bottom-1 before:w-4 before:h-4 before:rounded-full peer-checked:before:left-7 peer-checked:bg-primary before:transition-all before:duration-300"></span>
                        </label>
                        <span>{{ __('SELECT_ALL') }}</span>
                    </label>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach ($permission as $value)
                        <label class="inline-flex items-center cursor-pointer gap-2">
                            <label class="w-12 h-6 relative">
                                <input type="checkbox" name="permission[]" value="{{ $value->id }}"
                                    class="custom_switch permission-switch absolute w-full h-full opacity-0 z-10 cursor-pointer peer" id="permission_{{ $value->id }}"
                                    @if (in_array($value->id, $rolePermissions)) checked @endif>
                                <span for="permission_{{ $value->id }}" class="bg-[#ebedf2] dark:bg-dark block h-full rounded-full before:absolute before:left-1 before:bg-white dark:before:bg-white-dark dark:peer-checked:before:bg-white before:bottom-1 before:w-4 before:h-4 before:rounded-full peer-checked:before:left-7 peer-checked:bg-primary before:transition-all before:duration-300"></span>
                            </label>
                            <span class="dark:text-white-light">{{ $value->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('permission')
                    <div class="text-danger mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
                    {{ __('CANCEL') }}
                </a>
                <button type="submit" class="btn btn-primary">
                    {{ __('site.Edit') }}
                </button>
            </div>
        </form>
    </div>
@endsection

@section('js')
@endsection
