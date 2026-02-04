<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Admin;

class TelegramFile extends Model
{
    protected $fillable = [
        'file_id',
        'message_id',
        'chat_id',
        'telegram_file_path',
        'original_name',
        'mime_type',
        'size',
        'source',
        'type',
        'telegram_user_id',
        'uploaded_by',
    ];

    protected $casts = [
        'message_id' => 'integer',
        'size' => 'integer',
        'telegram_user_id' => 'integer',
    ];

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'uploaded_by', 'id');
    }
}
