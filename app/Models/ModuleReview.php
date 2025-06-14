<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
