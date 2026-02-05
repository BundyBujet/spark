<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemNotification extends Model
{
    protected $fillable = [
        'item_id',
        'notification_type',
        'sent_at',
        'channel',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
