<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create(CommentRequest $commentRequest)
    {
        // $comment = new Comment;

        // $comment->content = request()->content;
        // $comment->article_id = request()->article_id;
        // $comment->user_id = auth()->user()->id;
        // $comment->save();
        // return back();

        $data = $commentRequest->validated();
        $user = User::findOrFail(auth()->user()->id);

        $article = Article::findOrFail($data['article_id']);
        $comment = new Comment;

        $comment->fill([
            'content' => $data['content'],
        ]);
        $comment->user()->associate($user);
        $comment->article()->associate($article);
        $comment->save();
        return back();
    }

    public function delete($id)
    {
        $comment = Comment::find($id);
        if (Gate::allows('comment-delete', $comment)) {
            $comment->delete();
            return back()->with('info', 'Comment Deleted.');
        } else {
            return back()->with('error', 'Unauthorized.');
        }
        $comment->delete();
        return back();
    }
}
