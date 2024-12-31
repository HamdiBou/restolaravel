<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'isActive',
    ];
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
