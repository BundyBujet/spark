<?php

namespace App\Http\Requests;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;

class TaskListRequest extends FormRequest
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
            'priority' => ['nullable', 'string', 'in:'.implode(',', TaskPriority::values())],
            'task_status' => ['nullable', 'string', 'in:'.implode(',', TaskStatus::values())],
            'due_from' => ['nullable', 'date'],
            'due_to' => ['nullable', 'date'],
        ];
    }
}
