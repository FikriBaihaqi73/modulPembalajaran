<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property int $review_id
 * @property int $user_id
 * @property string $reply_content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ModuleReview $review
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewReply newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewReply newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewReply query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewReply whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewReply whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewReply whereReplyContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewReply whereReviewId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewReply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewReply whereUserId($value)
 * @mixin \Eloquent
 */
class ReviewReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id',
        'user_id',
        'reply_content',
    ];

    /**
     * Get the review that owns the reply.
     */
    public function review(): BelongsTo
    {
        return $this->belongsTo(ModuleReview::class, 'review_id');
    }

    /**
     * Get the user (mentor/admin) that owns the reply.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
