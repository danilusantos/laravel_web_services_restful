<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'image'
    ];

    public function getResults($data = null, $total)
    {
        if (! isset($data['filter']) && ! isset($data['name']) && ! isset($data['description'])) {
            return $this->paginate($total);
        }

        return $this->where(function ($query) use ($data) {
            if (isset($data['filter'])) {
                $filter = $data['filter'];
                $query->where('name', $filter);
                $query->orWhere('description', 'LIKE', "%{$filter}%");
            }

            if (isset($data['name'])) {
                $query->where('name', $data['name']);
            }

            if (isset($data['description'])) {
                $description = $data['description'];
                $query->where('description', 'LIKE', "%{$description}%");
            }
        })
        // ->toSql();
        ->paginate($total);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
