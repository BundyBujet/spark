<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TelegramFileUploadRequest extends FormRequest
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
            'file' => 'required|file|max:2097152', // 2GB in KB (Local Bot API limit)
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => __('TELEGRAM_FILE_REQUIRED'),
            'file.file' => __('TELEGRAM_FILE_INVALID'),
            'file.max' => __('TELEGRAM_FILE_TOO_LARGE'),
        ];
    }
}
