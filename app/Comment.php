<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Ramsey\Uuid\Uuid;

class Comment extends Model
{
    protected $casts = ['id' => 'string'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'author_id', 'postId', 'body'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /*
        public function getAuthorIdAttribute($value)
        {
            return substr($value, 0, 10);
        }
    */

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function username()
    {
        return $this->hasOne('App\Username', 'author_id', 'author_id');
    }

    public function createComment(array $data) {
        $newComment = $this->newInstance();

        $newComment->fill($data);

        $newComment['id'] = Uuid::uuid4()->toString();
        $newComment['author_id'] = Uuid::uuid4()->toString();

        $newComment->save();

        return $newComment;
    }
}
