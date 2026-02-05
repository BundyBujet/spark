<?php

namespace App\Http\Requests;

use App\Enums\ItemSource;
use App\Enums\ItemStatus;
use App\Enums\ItemType;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;

class ItemUpdateRequest extends FormRequest
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
        $rules = [
            'type' => ['sometimes', 'string', 'in:'.implode(',', ItemType::values())],
            'title' => ['sometimes', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'expires_at' => ['nullable', 'date'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', 'exists:tags,id'],
            'priority' => ['nullable', 'string', 'in:'.implode(',', TaskPriority::values())],
            'due_date' => ['nullable', 'date'],
            'task_status' => ['nullable', 'string', 'in:'.implode(',', TaskStatus::values())],
        ];
        if ($this->input('type') === ItemType::File->value) {
            $rules['telegram_file_id'] = ['required', 'integer', 'exists:telegram_files,id'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'telegram_file_id.required' => __('SELECT_TELEGRAM_FILE'),
            'telegram_file_id.exists' => __('TELEGRAM_FILE_INVALID'),
        ];
    }
}
