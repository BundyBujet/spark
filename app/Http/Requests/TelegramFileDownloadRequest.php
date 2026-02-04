<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TelegramFileDownloadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->can('Manage Telegram Storage');
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [];
    }
}
