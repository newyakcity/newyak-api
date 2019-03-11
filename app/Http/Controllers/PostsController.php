<?php

namespace App\Http\Controllers;

use App\Services\UsernameService;
use App\Username;
use Illuminate\Http\Request;

use App\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public $post;
    public $username;
    public $usernameService;

    function __construct(Post $post, Username $username, UsernameService $usernameService)
    {
        $this->post = $post;
        $this->username = $username;
        $this->usernameService = $usernameService;
    }

    function create(Request $request)
    {
        $data = $request->json()->all();

        $validator = Validator::make($data, [
            'title' => 'required',
            'body' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $newPost = $this->post->createPost($data);

        $username = $this->username->newInstance();

        $username['username'] = $this->usernameService->generateUsername($newPost['author_id']);
        $username['usernameable_id'] = $newPost['id'];
        $username['usernameable_type'] = Post::class;

        $username->save();

        $newPost['username'] = ['username' => $username['username']];

        return response()->json($newPost);
    }

    function get(string $id)
    {
        $res = $this->post->with(['comments.username', 'username'])
            ->withCount('comments')
            ->find($id);

        return response()->json($res);
    }

    function search(Request $request)
    {
        $lat = $request->get('lat');
        $lng = $request->get('lng');

        if(empty($lat) || empty($lng))
        {
            return response()->json(['error' => 'lat and lng parameters are required'], 400);
        }

        return response()->json($this->post->searchPosts($lat, $lng));
    }
}
