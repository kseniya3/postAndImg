<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $fillable = [
        'name', 'storage', 'path', 'type', 'articles_id',
    ];

    public function articl()
    {
        return $this->belongsTo('App\Models\Articl');
    }
}
