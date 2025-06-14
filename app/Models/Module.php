<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $content
 * @property string|null $thumbnail
 * @property int $is_visible
 * @property int $major_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ModuleProgress|null $currentUserProgress
 * @property-read float|null $average_rating
 * @property-read bool $is_completed_by_current_user
 * @property-read \App\Models\Major $major
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ModuleCategory> $moduleCategory
 * @property-read int|null $module_category_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ModuleProgress> $progress
 * @property-read int|null $progress_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ModuleReview> $reviews
 * @property-read int|null $reviews_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Module newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Module newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Module query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Module whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Module whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Module whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Module whereIsVisible($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Module whereMajorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Module whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Module whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Module whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Module whereUserId($value)
 * @mixin \Eloquent
 */
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
     * Get the reviews for the module.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(ModuleReview::class);
    }

    /**
     * Get the average rating for the module.
     */
    public function getAverageRatingAttribute(): ?float
    {
        return $this->reviews->avg('rating');
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