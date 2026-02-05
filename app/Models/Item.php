<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    protected $fillable = [
        'type',
        'title',
        'content',
        'status',
        'expires_at',
        'source',
        'telegram_file_id',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function telegramFile(): BelongsTo
    {
        return $this->belongsTo(TelegramFile::class, 'telegram_file_id', 'id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'item_tag');
    }

    public function task(): HasOne
    {
        return $this->hasOne(Task::class);
    }

    public function itemNotifications(): HasMany
    {
        return $this->hasMany(ItemNotification::class);
    }
}
