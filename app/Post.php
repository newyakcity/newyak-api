<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Ramsey\Uuid\Uuid;

class Post extends Model
{
    public $incrementing = false;

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

    public function comments()
    {
        return $this->hasMany('App\Comment', 'postId');
    }

    public function latestComment()
    {
        return $this->hasMany('App\Comment', 'postId')->latest();
    }

    public function username()
    {
        return $this->morphOne(Username::class, 'usernameable');
    }

    public function searchPosts(string $lat, string $lng) {

        $res = $this->whereRaw(
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
            ->with('username')
            ->orderByRaw('(.6 * comments_count) + (.4 * TIMESTAMPDIFF(MINUTE, CURTIME(), created_at)) DESC')
            ->get();

        return $res;
    }

    public function cleanupPosts() {
        $now = Carbon::now();

        $now->subHour();

        // Delete posts older than 30 min w/o comments
        $this
        ->where('created_at', '<', Carbon::now()->subMinutes(30)->toDateTimeString())
        ->doesnthave('comments')
        ->delete();

        // Delete posts where latest comment was > 30 min ago
        $withComments = $this
        ->whereHas('latestComment', function($query) {
            $fmin = Carbon::now();
            $fmin->subMinutes(30);

            $query->where('created_at', '<', $fmin->toDateTimeString());
        })->get();

        foreach ($withComments as $post) {
            $post->comments()->delete();
            $post->delete();
        }
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
