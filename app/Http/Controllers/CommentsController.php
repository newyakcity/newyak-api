<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    public $comment;

    function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    function create(Request $request)
    {
        $data = $request->json()->all();

        $validator = Validator::make($data, [
            'postId' => 'required',
            'body' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $newPost = $this->comment->createComment($data);

        return response()->json($newPost);
    }
}
