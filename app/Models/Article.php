<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'name',
        'description',
        'imageUrl',
        'isActive',
        'price',
        'stock',
    ];

    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }
}