<?php

namespace App\Http\Requests;

use App\Enums\NotificationChannel;
use App\Enums\NotificationType;
use Illuminate\Foundation\Http\FormRequest;

class ItemNotificationListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'item_id' => ['nullable', 'integer', 'exists:items,id'],
            'notification_type' => ['nullable', 'string', 'in:'.implode(',', NotificationType::values())],
            'channel' => ['nullable', 'string', 'in:'.implode(',', NotificationChannel::values())],
            'from_date' => ['nullable', 'date'],
            'to_date' => ['nullable', 'date'],
        ];
    }
}
