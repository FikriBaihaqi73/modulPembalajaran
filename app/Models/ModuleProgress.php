<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $module_id
 * @property int $is_completed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Module $module
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleProgress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleProgress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleProgress query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleProgress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleProgress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleProgress whereIsCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleProgress whereModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleProgress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleProgress whereUserId($value)
 * @mixin \Eloquent
 */
class ModuleProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'module_id',
        'is_completed',
    ];

    /**
     * Get the user that owns the module progress.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the module that owns the module progress.
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
