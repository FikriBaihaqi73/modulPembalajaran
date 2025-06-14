<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $major_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Major $major
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Module> $modules
 * @property-read int|null $modules_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleCategory whereMajorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ModuleCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ModuleCategory extends Model
{
    protected $fillable = ['name', 'major_id'];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'module_module_category', 'module_category_id', 'module_id');
    }
}
