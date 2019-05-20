<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Username extends Model
{
    public $casts = ['usernameable_id' => 'string'];


    public function usernameable()
    {
        return $this->morphTo();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'usernameable_id', 'usernameable_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'usernameable_id', 'usernameable_type', 'created_at', 'updated_at'
    ];

    public function comment()
    {
        return $this->morphTo('usernameable', 'App\Comment', 'id');
    }

    public function post()
    {
        return $this->morphTo('usernameable', 'App\Post', 'id');
    }
}
