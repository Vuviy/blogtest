<?php

namespace App\Http\Controllers;

use App\Jobs\EmailNotification;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Comment extends Controller
{
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
            EmailNotification::dispatch($comment);
            return response()->json(['success' => true, 'name' => $comment->author, 'text' => $comment->text], 200);
        }

        return response()->json(['errors' => 'Comment not created'], 401);
    }
}
