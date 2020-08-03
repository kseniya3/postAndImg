<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articl extends Model
{
    protected $fillable = [
        'name', 'date', 'content', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function pictures()
    {
        return $this->hasMany('App\Models\Picture');
    }
}
