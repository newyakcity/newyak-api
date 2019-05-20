<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Ramsey\Uuid\Uuid;

class Comment extends Model
{
    public $incrementing = false;

    protected $casts = ['id' => 'string'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'author_id', 'body', 'commentable_id', 'commentable_type'
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
        return $this->morphTo('commentable', 'App\Post', 'id');
    }

    public function comment()
    {
        return $this->morphTo('commentable', 'App\Comment', 'id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function username()
    {
        return $this->morphOne(Username::class, 'usernameable');
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
