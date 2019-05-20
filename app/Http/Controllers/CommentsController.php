<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Services\UsernameService;
use App\Username;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    public $comment;
    public $username;
    public $usernameService;

    function __construct(Comment $comment, Username $username, UsernameService $usernameService)
    {
        $this->comment = $comment;
        $this->username = $username;
        $this->usernameService = $usernameService;
    }

    function getPostComments(string $postId)
    {
        $comments = $this->comment->where('postId', '=', $postId)->with(['username'])->get();

        return response()->json($comments);
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

        if($data['commentId']) {
            $data['commentable_type'] = Comment::class;
            $data['commentable_id'] = $data['commentId'];

            unset($data['commentId']);

        } else {
            $postId = $data['postId'];

            $data['commentable_type'] = Post::class;
            $data['commentable_id'] = $postId;
        }

        unset($data['postId']);

        $newPost = $this->comment->createComment($data);

        $username = $this->username->newInstance();

        $username['username'] = $this->usernameService->generateUsername($newPost['author_id']);
        $username['usernameable_id'] = $newPost['id'];
        $username['usernameable_type'] = Comment::class;

        $username->save();

        $newPost['username'] = ['username' => $username['username']];

        return response()->json($newPost);
    }
}
