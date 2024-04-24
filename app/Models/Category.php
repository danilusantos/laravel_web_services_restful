<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'name'
    ];

    public function getResults($name = null)
    {
        if (!$name) {
            return $this->get();
        }

        return $this->where('name', 'LIKE', "%{$name}%")->get();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
