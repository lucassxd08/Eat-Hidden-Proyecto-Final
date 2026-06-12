<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'active'];

    protected $casts = ['active' => 'boolean'];

    public function dishes()
    {
        return $this->hasMany(Dish::class);
    }
}
