<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $module_id
 * @property int $rating Rating from 1 to 5
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Module $module
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ReviewReply> $replies
 * @property-read int|null $replies_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleReview query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleReview whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleReview whereModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleReview whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleReview whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleReview whereUserId($value)
 * @mixin \Eloquent
 */
class ModuleReview extends Model
{
    protected $fillable = [
        'user_id',
        'module_id',
        'rating',
        'comment',
    ];

    /**
     * Get the user that owns the review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the module that the review belongs to.
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Get the replies for the review.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(ReviewReply::class, 'review_id');
    }
}
