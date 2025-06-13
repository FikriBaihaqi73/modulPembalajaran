<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function moduleCategory()
    {
        return $this->belongsToMany(ModuleCategory::class, 'module_module_category', 'module_id', 'module_category_id');
    }
}
