<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Module extends Model
{
    protected $fillable = [
        'name',
        'content',
        'thumbnail',
        'is_visible',
        'major_id',
        'user_id',
    ];

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    public function moduleCategory(): BelongsToMany
    {
        return $this->belongsToMany(ModuleCategory::class, 'module_module_category', 'module_id', 'module_category_id');
    }

    /**
     * Get the user (mentor) that owns the module.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the module progress records for the module.
     */
    public function progress(): HasMany
    {
        return $this->hasMany(ModuleProgress::class);
    }

    /**
     * Get the module progress for the currently authenticated user.
     */
    public function currentUserProgress(): HasOne
    {
        return $this->hasOne(ModuleProgress::class)->where('user_id', Auth::id());
    }

    /**
     * Determine if the module is completed by the current user.
     */
    public function getIsCompletedByCurrentUserAttribute(): bool
    {
        return (bool) $this->currentUserProgress?->is_completed;
    }
}