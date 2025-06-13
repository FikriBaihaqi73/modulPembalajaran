<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Major extends Model
{
    protected $fillable = ['name'];

    /**
     * Get the users for the major.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the modules for the major.
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }
}
