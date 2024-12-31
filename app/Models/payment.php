<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Specify the table associated with the model (optional if table name is the plural of the model name)
    protected $table = 'payments';

    // Specify the columns that are mass assignable
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'articles',
        'status'
    ];

    // Define relationships if necessary, e.g., with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Mutators or Accessors if you need to manipulate the data
    public function getArticlesAttribute($value)
    {
        return json_decode($value);
    }

    public function setArticlesAttribute($value)
    {
        $this->attributes['articles'] = json_encode($value);
    }
}
