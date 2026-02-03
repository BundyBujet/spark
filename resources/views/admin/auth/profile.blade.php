@extends('layouts.master')

@section('title')
    {{ env('APP_NAME') }}- {{ __('title.MyProfile') }}
@endsection

@section('sidebar_section')
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@php
    $errors_type = $errors->keys();
    $isError_password_tab = false;
    if ($errors_type) {
        foreach ($errors_type as $error) {
            if (str_contains($error, 'password')) {
                $isError_password_tab = true;
            }
        }
    }
@endphp

@section('content')
    <x-breadcrumb :items="[
        ['label' => 'DASHBOARD', 'route' => 'admin.dashboard'],
        ['label' => 'PROFILE', 'route' => 'admin.profile'],
        ['label' => 'SETTINGS']
    ]" />
    <div>
        <div class="pt-5">
            <div class="flex justify-between items-center mb-5">
                <h5 class="text-lg font-semibold dark:text-white-light">
                    {{ __('SETTINGS') }}
                </h5>
            </div>
            {{-- make the tab woth the error message active and defualt to info --}}
            <div x-data="{ tab: '{{ $isError_password_tab ? 'passwordRest' : 'info' }}' }">
                <ul
                    class="mb-5 overflow-y-auto whitespace-nowrap border-b border-[#ebedf2] font-semibold dark:border-[#191e3a] sm:flex">
                    <li class="inline-block">
                        <a href="javascript:;"
                            class="flex items-center gap-2 border-b border-transparent p-4 hover:border-primary hover:text-primary !border-primary text-primary"
                            :class="{ '!border-primary text-primary': tab == 'info' }" @click="tab='info'">
                            <i class="ri-information-line text-xl"></i>
                            {{ __('HOME') }}
                        </a>
                    </li>
                    <li class="inline-block">
                        <a href="javascript:;"
                            class="flex items-center gap-2 border-b border-transparent p-4 hover:border-primary hover:text-primary !border-primary text-primary"
                            :class="{ '!border-primary text-primary': tab == 'passwordRest' }" @click="tab='passwordRest'">
                            <i class="ri-lock-2-line text-xl"></i>
                            {{ __('PASSWORD_REST') }}
                        </a>
                    </li>
                </ul>

                <template x-if="tab === 'info'">
                    <div>
                        <form action="{{ route('admin.update.profile', Auth::user()->id) }}" method="POST"
                            enctype="multipart/form-data"
                            class="mb-5 rounded-md border border-[#ebedf2] bg-white p-4 dark:border-[#191e3a] dark:bg-[#0e1726]">
                            @csrf
                            <h6 class="mb-5 text-lg font-bold">
                                {{ __('GENERAL_INFO') }}
                            </h6>
                            <div class="flex flex-col sm:flex-row">
                                <div class="mb-5 w-full sm:w-2/12 ltr:sm:mr-4 rtl:sm:ml-4">
                                    @if (auth()->user()->image)
                                        <img src="{{ asset('assets/images/' . auth()->user()->image) }}" alt="image"
                                            class="object-cover mx-auto w-20 h-20 rounded-full md:h-32 md:w-32" />
                                    @else
                                        <div class="object-cover mx-auto w-20 h-20 rounded-full md:h-32 md:w-32">
                                            {!! Avatar::create(auth()->user()->name)->toSvg() !!}
                                        </div>
                                    @endif
                                </div>
                                <div class="grid flex-1 grid-cols-1 gap-5 sm:grid-cols-2">
                                    <div>
                                        <label for="name">{{ __('NAME') }}</label>
                                        <input id="name" type="text" name="name"
                                            placeholder="{{ __('NAME') }}" value="{{ Auth::user()->name }}"
                                            class="form-input" />
                                        @error('name')
                                            <div class="text-danger my-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="username">{{ __('USERNAME') }}</label>
                                        <input id="username" type="text" name="username"
                                            placeholder="{{ __('USERNAME') }}" value="{{ Auth::user()->username }}"
                                            class="form-input" />
                                        @error('username')
                                            <div class="text-danger my-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="phone">{{ __('PHONE') }}</label>
                                        <input id="phone" type="text" name="phone"
                                            placeholder="{{ __('PHONE') }}" value="{{ Auth::user()->phone }}"
                                            class="form-input" />
                                        @error('phone')
                                            <div class="text-danger my-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="image"> {{ __('PROFILE_PIC') }}</label>
                                        <input id="image" type="file" name="image" accept="image/png, image/jpeg"
                                            class="p-0 form-input file:py-2 file:px-4 file:border-0 file:font-semibold file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white file:hover:bg-primary" />
                                        @error('image')
                                            <div class="text-danger my-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mt-3 sm:col-span-2">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('SUBMIT') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </template>
                <template x-if="tab === 'passwordRest'">
                    <div>
                        <form action="{{ route('admin.change.password', Auth::user()->id) }}" method="POST"
                            enctype="multipart/form-data"
                            class="mb-5 rounded-md border border-[#ebedf2] bg-white p-4 dark:border-[#191e3a] dark:bg-[#0e1726]">
                            @csrf
                            <h6 class="mb-5 text-lg font-bold">
                                {{ __('PASSWORD_REST') }}
                            </h6>
                            <div class="flex flex-col sm:flex-row">
                                <div class="mb-5 w-full sm:w-2/12 ltr:sm:mr-4 rtl:sm:ml-4">
                                    @if (auth()->user()->image)
                                        <img src="{{ asset('assets/images/' . auth()->user()->image) }}" alt="image"
                                            class="object-cover mx-auto w-20 h-20 rounded-full md:h-32 md:w-32" />
                                    @else
                                        <div class="object-cover mx-auto w-20 h-20 rounded-full md:h-32 md:w-32">
                                            {!! Avatar::create(auth()->user()->name)->toSvg() !!}
                                        </div>
                                    @endif
                                </div>
                                <div class="grid flex-1 grid-cols-1 gap-5 sm:grid-cols-2">
                                    <div>
                                        <label for="old_password">{{ __('OLD_PASSWORD') }}</label>
                                        <input id="old_password" type="password" name="old_password"
                                            placeholder="{{ __('OLD_PASSWORD') }}" class="form-input" />
                                        @error('old_password')
                                            <div class="text-danger my-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="new_password">{{ __('NEW_PASSWORD') }}</label>
                                        <input id="new_password" type="password" name="new_password"
                                            placeholder="{{ __('NEW_PASSWORD') }}" class="form-input" />
                                        @error('new_password')
                                            <div class="text-danger my-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="confirm_password">{{ __('CONFIRM_PASSWORD') }}</label>
                                        <input id="confirm_password" type="password" name="confirm_password"
                                            placeholder="{{ __('CONFIRM_PASSWORD') }}" class="form-input" />

                                        @error('confirm_password')
                                            <div class="text-danger my-2">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mt-3 sm:col-span-2">
                                        <div class="flex gap-6">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('SUBMIT') }}
                                            </button>
                                            <button type="reset" class="btn btn-outline-secondary">
                                                {{ __('RESET') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </template>
            </div>
        </div>
    </div>
@endsection
