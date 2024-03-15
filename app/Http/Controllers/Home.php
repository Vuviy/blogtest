<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Home extends Controller
{
    public function index()
    {

        $articles = Article::latest();
//
//        $mostComment = $articles->;

        $mostComment = $articles->withCount('comments')
        ->orderByDesc('comments_count')
        ->take(5)
        ->get();


//        dd($mostComment);


        return view('home', ['articles' => $articles->paginate(10), 'mostComment' => $mostComment]);
    }

    public function article($id)
    {

        $article = Article::query()->where('id', $id)->first();

        return view('article', ['article' => $article]);
    }


    public function addComment(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:50|string',
            'text' => 'required|min:3|max:150|string',
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $article = Article::query()->where('id', $request->id)->first();

        if(!$article){
            return response()->json(['errors' => 'Article not found'], 404);
        }

       $comment = $article->comments()->create(['author' => $request->name, 'text' => $request->text, ]);

        if($comment)
        {
            return response()->json(['success' => true, 'name' => $comment->author, 'text' => $comment->text], 200);
        }

        return response()->json(['errors' => 'Comment not created'], 401);
    }
}
