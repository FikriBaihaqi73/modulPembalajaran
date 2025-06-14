<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'target_audience',
        'major_id',
        'published_at',
        'expires_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user that owns the announcement.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the major that the announcement belongs to (if any).
     */
    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    /**
     * Scope a query to only include active announcements.
     */
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('published_at')
              ->orWhere('published_at', '<=', now());
        })->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>=', now());
        });
    }
}
