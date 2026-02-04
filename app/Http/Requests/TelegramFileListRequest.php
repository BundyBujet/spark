<?php

namespace App\Http\Requests;

use App\Enums\TelegramFileSource;
use App\Enums\TelegramFileType;
use Illuminate\Foundation\Http\FormRequest;

class TelegramFileListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('Manage Telegram Storage') ?? false;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'source' => ['nullable', 'string', 'in:'.implode(',', TelegramFileSource::values())],
            'type' => ['nullable', 'string', 'in:'.implode(',', TelegramFileType::values())],
        ];
    }
}
