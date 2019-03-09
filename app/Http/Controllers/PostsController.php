<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;

class PostsController extends Controller
{
    private $post;

    function constructor(Post $post)
    {
        $this->post = $post;
    }

    function search(Request $request)
    {
        $lat = $request->get('lat');
        $lng = $request->get('lng');

        if(empty($lat) || empty($lng))
        {
            return response()->json(['error' => 'lat and lng parameters are required'], 400);
        }

        return response()->json([]);
    }
}
