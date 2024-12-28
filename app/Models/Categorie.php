<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = [
        'name',
        'description',
        'imageUrl',
        'isActive',
    ];
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
