<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Articl extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'date', 'content', 'user_id',
    ];

    protected $table = 'articles';
    protected $dates = ['deleted_at'];

    public function user(){

        return $this->belongsTo('App\Models\User');
    }

    public function pictures(){

        return $this->hasMany('App\Models\Picture','articles_id');
    }
}
