<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
