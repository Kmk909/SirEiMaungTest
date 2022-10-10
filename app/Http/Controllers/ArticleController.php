<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'detail']);
    }
    public function index()
    {
        $data = Article::orderBy('updated_at', 'desc')->paginate(5);
        return view('articles.index', ['articles' => $data]);
    }

    public function detail($id)
    {
        $data = Article::find($id);
        return view('articles.detail', ['article' => $data]);
    }

    // public function details()
    // {
    //     return "Controller-Article Details";
    // }

    public function add()
    {
        $data = Category::get(['id', 'name'])->toArray();

        return view('articles.add', ['categories' => $data]);
    }

    public function create(ArticleRequest $articleRequest)
    {
        // $validator = validator(request()->all(), [
        //     'title' => 'required',
        //     'body' => 'required',
        //     'category_id' => 'required',
        // ]);
        // if($validator->fails()) {
        // return back()->withErrors($validator);
        // }
        // $article->title = $data['title'];
        // $article->body = $data['body'];
        // $article->category_id = $data['category_id'];


        $data = $articleRequest->validated();
        $category = Category::findOrFail($data['category_id']);
        $article = new Article;
        $user = User::findOrFail(auth()->user()->id);

        $article->fill([
            'title' => $data['title'],
            'body'  => $data['body']
        ]);
        $article->category()->associate($category);
        $article->user()->associate($user);
        $article->save();

        return redirect('/articles');
    }

    public function delete($id)
    {
        $article = Article::find($id);

        if (Gate::allows('article-delete', $article)) {
            $article->delete();
            return redirect('/articles')->with('info', "Article  $id deleted");
        } else {
            return back()->with('error', 'Delete unauthorized.');
        }
    }

    public function edit($id)
    {
        $article = Article::find($id);

        $data = Category::get(['id', 'name'])->toArray();
        if (Gate::allows('article-edit', $article)) {
            return view('articles.edit', ['article' => $article], ['categories' => $data]);
        } else {
            return back()->with('error', 'Edit unauthorized');
        }
    }

    public function update(ArticleRequest $articleRequest, $id)
    {
        // $validator = validator(request()->all(), [
        //     'title' => 'required',
        //     'body' => 'required',
        //     'category_id' => 'required',
        // ]);
        // if ($validator->fails()) {
        //     return back()->withErrors($validator);
        // }
        // $article->title = request()->title;
        // $article->body = request()->body;
        // $article->category_id = request()->category_id;

        $data = $articleRequest->validated();
        $category = Category::findOrFail($data['category_id']);
        $article = Article::find($id);

        $article->fill([
            'title' => $data['title'],
            'body'  => $data['body']
        ]);
        $article->category()->associate($category);

        $article->update();

        return redirect('/articles')->with('info', "Article successfully updated.");
    }
}
