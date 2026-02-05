@extends('layouts.master')

@section('title')
    {{ env('APP_NAME') }} - {{ __('WEEKLY_REPORTS') }}
@endsection

@section('sidebar_section')
weekly-reports
@endsection

@section('css')
@endsection

@section('content')
    <x-breadcrumb :items="[
        ['label' => 'DASHBOARD', 'route' => 'admin.dashboard'],
        ['label' => 'WEEKLY_REPORTS']
    ]" />
    <div class="panel">
        <h5 class="text-lg font-semibold dark:text-white-light mb-5">{{ __('WEEKLY_REPORTS') }}</h5>
        <p class="text-muted text-sm mb-5">{{ __('WEEKLY_REPORTS_SYSTEM_CREATED') }}</p>

        @if (isset($reports) && $reports->count() > 0)
            <div class="table-responsive">
                <table class="table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('WEEKLY_REPORTS_PERIOD_START') }}</th>
                            <th>{{ __('WEEKLY_REPORTS_PERIOD_END') }}</th>
                            <th>{{ __('WEEKLY_REPORTS_SUMMARY') }}</th>
                            <th>{{ __('WEEKLY_REPORTS_SENT_AT') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = ($reports->currentPage() - 1) * $reports->perPage() + 1;
                        @endphp
                        @foreach ($reports as $report)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $report->period_start?->format('Y-m-d') }}</td>
                                <td>{{ $report->period_end?->format('Y-m-d') }}</td>
                                <td>{{ Str::limit($report->summary, 80) ?: '—' }}</td>
                                <td>{{ $report->sent_at?->format('Y-m-d H:i') ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $reports->links() }}
            </div>
        @else
            <div class="alert alert-info">
                {{ __('NO_RESULTS_FOUND') }}
            </div>
        @endif
    </div>
@endsection

@section('js')
@endsection
