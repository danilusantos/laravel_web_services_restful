<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image'
    ];

    public function getResults($name = null)
    {
        if (!$name) {
            return $this->get();
        }

        return $this->where('name', 'LIKE', "%{$name}%")->get();
    }
}