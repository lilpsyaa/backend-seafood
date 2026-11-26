<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = ['user_id', 'name'];

    public function seafoodLists()
    {
        return $this->hasMany(SeafoodList::class);
    }
}