<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Ramsey\Uuid\Uuid;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'authorId', 'title', 'body', 'latitude', 'longitude'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function  comments()
    {
        return $this->hasMany('App\Comment', 'postId');
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
            ->with('comments')
            ->get();
    }

    public function createPost(array $data) {
        $newPost = $this->newInstance();

        $newPost->fill($data);

        $newPost['id'] = Uuid::uuid4()->toString();
        $newPost['authorId'] = Uuid::uuid4()->toString();

        $newPost->save();

        return $newPost;
    }
}
