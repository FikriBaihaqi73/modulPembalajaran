<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'name',
        'content',
        'major_id',
        'module_category_id',
        'user_id',
    ];
}
