<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Username extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id', 'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id'
    ];

    public function comment()
    {
        return $this->belongsTo('App\Comment', 'author_id', 'author_id');
    }

    public function post()
    {
        return $this->belongsTo('App\Post', 'author_id', 'author_id');
    }
}
