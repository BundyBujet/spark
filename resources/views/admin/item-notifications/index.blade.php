@extends('layouts.master')

@section('title')
    {{ env('APP_NAME') }} - {{ __('ITEM_NOTIFICATIONS') }}
@endsection

@section('sidebar_section')
item-notifications
@endsection

@section('css')
@endsection

@section('content')
    <x-breadcrumb :items="[
        ['label' => 'DASHBOARD', 'route' => 'admin.dashboard'],
        ['label' => 'ITEM_NOTIFICATIONS']
    ]" />
    <div class="panel">
        <h5 class="text-lg font-semibold dark:text-white-light mb-5">{{ __('ITEM_NOTIFICATIONS') }}</h5>

        <form method="GET" action="{{ route('item-notifications.index') }}" class="mb-5 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
            <div class="flex flex-wrap items-end gap-3">
                <div>
                    <label for="item_id" class="block text-sm font-medium mb-1 dark:text-white-light">{{ __('ITEM_NOTIFICATIONS_ITEM_ID') }}</label>
                    <input type="number" id="item_id" name="item_id" value="{{ request('item_id') }}" min="1" class="form-input form-input-sm w-24" placeholder="ID">
                </div>
                <div>
                    <label for="notification_type" class="block text-sm font-medium mb-1 dark:text-white-light">{{ __('ITEM_NOTIFICATIONS_TYPE') }}</label>
                    <select id="notification_type" name="notification_type" class="form-select form-select-sm">
                        <option value="">{{ __('ITEMS_ALL') }}</option>
                        @foreach (\App\Enums\NotificationType::cases() as $case)
                            <option value="{{ $case->value }}" @selected(request('notification_type') === $case->value)>{{ ucfirst(str_replace('_', ' ', $case->value)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="channel" class="block text-sm font-medium mb-1 dark:text-white-light">{{ __('ITEM_NOTIFICATIONS_CHANNEL') }}</label>
                    <select id="channel" name="channel" class="form-select form-select-sm">
                        <option value="">{{ __('ITEMS_ALL') }}</option>
                        @foreach (\App\Enums\NotificationChannel::cases() as $case)
                            <option value="{{ $case->value }}" @selected(request('channel') === $case->value)>{{ ucfirst($case->value) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="from_date" class="block text-sm font-medium mb-1 dark:text-white-light">{{ __('ITEM_NOTIFICATIONS_FROM_DATE') }}</label>
                    <input type="date" id="from_date" name="from_date" value="{{ request('from_date') }}" class="form-input form-input-sm">
                </div>
                <div>
                    <label for="to_date" class="block text-sm font-medium mb-1 dark:text-white-light">{{ __('ITEM_NOTIFICATIONS_TO_DATE') }}</label>
                    <input type="date" id="to_date" name="to_date" value="{{ request('to_date') }}" class="form-input form-input-sm">
                </div>
                <button type="submit" class="btn btn-sm btn-primary">{{ __('ITEMS_FILTER') }}</button>
                <a href="{{ route('item-notifications.index') }}" class="btn btn-sm btn-outline-secondary">{{ __('ITEMS_CLEAR') }}</a>
            </div>
        </form>

        @if (isset($notifications) && $notifications->count() > 0)
            <div class="table-responsive">
                <table class="table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('ITEM_NOTIFICATIONS_ITEM') }}</th>
                            <th>{{ __('ITEM_NOTIFICATIONS_TYPE') }}</th>
                            <th>{{ __('ITEM_NOTIFICATIONS_SENT_AT') }}</th>
                            <th>{{ __('ITEM_NOTIFICATIONS_CHANNEL') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = ($notifications->currentPage() - 1) * $notifications->perPage() + 1;
                        @endphp
                        @foreach ($notifications as $notification)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>
                                    @if ($notification->item)
                                        <a href="{{ route('items.show', $notification->item) }}" class="font-semibold text-primary hover:underline">{{ Str::limit($notification->item->title, 40) }}</a>
                                        <span class="text-muted text-xs">(#{{ $notification->item_id }})</span>
                                    @else
                                        <span class="text-muted">#{{ $notification->item_id }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $notification->notification_type)) }}</span>
                                </td>
                                <td>{{ $notification->sent_at?->format('Y-m-d H:i') }}</td>
                                <td>
                                    <span class="badge bg-outline-primary">{{ ucfirst($notification->channel) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $notifications->links() }}
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
