<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public $post;

    function __construct(Post $post)
    {
        $this->post = $post;
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

        return response()->json($newPost);
    }

    function get(string $id)
    {
        return $this->post->with('comments')->find($id);
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
