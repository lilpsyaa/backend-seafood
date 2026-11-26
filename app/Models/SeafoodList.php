<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeafoodList extends Model
{
    protected $fillable = [
        'user_id',
        'restaurant_id',
        'title',
        'main_ingredient',
        'notes',
        'image_url',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}