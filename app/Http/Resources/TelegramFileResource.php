<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TelegramFileResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'file_id' => $this->file_id,
            'original_name' => $this->original_name,
            'mime_type' => $this->mime_type,
            'size' => $this->size,
            'source' => $this->source,
            'type' => $this->type,
            'created_at' => $this->created_at?->toIso8601String(),
            'download_url' => $this->when(
                $request->routeIs('*.show', '*.download'),
                fn () => route('telegram-storage.download', $this->resource)
            ),
        ];
    }
}
