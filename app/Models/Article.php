<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'isActive',
        'price',
        'stock',
        'categorie_id',
    ];

    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }
}