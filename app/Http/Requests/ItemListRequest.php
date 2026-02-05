<?php

namespace App\Http\Requests;

use App\Enums\ItemSource;
use App\Enums\ItemStatus;
use App\Enums\ItemType;
use Illuminate\Foundation\Http\FormRequest;

class ItemListRequest extends FormRequest
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
            'type' => ['nullable', 'string', 'in:'.implode(',', ItemType::values())],
            'status' => ['nullable', 'string', 'in:'.implode(',', ItemStatus::values())],
            'source' => ['nullable', 'string', 'in:'.implode(',', ItemSource::values())],
            'tag_id' => ['nullable', 'integer', 'exists:tags,id'],
            'expiring_soon' => ['nullable', 'boolean'],
        ];
    }
}
