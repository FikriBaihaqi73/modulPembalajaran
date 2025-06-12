<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleCategory extends Model
{
    protected $fillable = ['name', 'major_id'];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }
}
