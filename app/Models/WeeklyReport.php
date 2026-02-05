<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyReport extends Model
{
    protected $fillable = [
        'period_start',
        'period_end',
        'summary',
        'sent_at',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'sent_at' => 'datetime',
    ];
}
