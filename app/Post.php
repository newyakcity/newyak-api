<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Ramsey\Uuid\Uuid;

class Post extends Model
{
    protected $casts = ['id' => 'string'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'author_id', 'title', 'body', 'latitude', 'longitude'
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

    public function  comments()
    {
        return $this->hasMany('App\Comment', 'postId');
    }

    public function username()
    {
        return $this->hasOne('App\Username', 'author_id', 'author_id');
    }

    public function searchPosts(string  $lat, string $lng) {
        return $this->whereRaw(
            DB::raw("(
                3959 *
                acos(
                    cos( radians( ? ) ) *
                    cos( radians( `latitude` ) ) *
                    cos(
                        radians( `longitude` ) - radians( ? )
                    ) +
                    sin(radians(?)) *
                    sin(radians(`latitude`))
                )
                ) < 5"
            ), [$lat, $lng, $lat])
            ->withCount('comments')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function createPost(array $data) {
        $newPost = $this->newInstance();

        $newPost->fill($data);

        $newPost['id'] = Uuid::uuid4()->toString();
        $newPost['author_id'] = Uuid::uuid4()->toString();

        $newPost->save();

        return $newPost;
    }
}
