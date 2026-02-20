<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Normalize tag name: lowercase and spaces to underscores (snake_case).
     */
    public static function normalizeName(string $name): string
    {
        $name = trim($name);
        $name = strtolower($name);
        $name = (string) preg_replace('/\s+/', '_', $name);
        $name = (string) preg_replace('/_+/', '_', $name); // collapse multiple underscores
        return trim($name, '_');
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'item_tag');
    }
}
