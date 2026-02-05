<?php

namespace App\Http\Requests;

use App\Enums\ItemSource;
use App\Enums\ItemStatus;
use App\Enums\ItemType;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemStoreRequest extends FormRequest
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
            'type' => ['required', 'string', 'in:' . implode(',', ItemType::values())],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'expires_at' => ['nullable', 'date'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', 'exists:tags,id'],
        ];

        if ($this->input('type') === ItemType::Task->value) {
            $rules['priority'] = ['nullable', 'string', 'in:' . implode(',', TaskPriority::values())];
            $rules['due_date'] = ['nullable', 'date'];
            $rules['task_status'] = ['nullable', 'string', 'in:' . implode(',', TaskStatus::values())];
        }

        if ($this->input('type') === ItemType::File->value) {

            $rules['telegram_file_id'] = ['required', 'integer', 'exists:telegram_files,id'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'telegram_file_id.required' => __('TELEGRAM_FILE_REQUIRED'),
            'telegram_file_id.exists' => __('TELEGRAM_FILE_INVALID'),
        ];
    }
}
