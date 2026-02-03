@extends('layouts.master')

@section('title')
    {{ env('APP_NAME') }}-{{ __('title.Dashboard') }}
@endsection

@section('sidebar_section')
@endsection

@section('css')
@endsection


@section('content')
    <x-breadcrumb :items="[
        ['label' => 'DASHBOARD']
    ]" />
    <div class="container-xxl flex-grow-1 container-p-y">


    </div>
@endsection


@section('js')
@endsection
