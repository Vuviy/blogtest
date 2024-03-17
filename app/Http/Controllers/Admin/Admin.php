<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\EmailNotification;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Admin extends Controller
{
    public function index()
    {

//        $comment = Comment::first();
//
//        EmailNotification::dispatch($comment);
//
//        dd(1);
//        $today = Carbon::now();

//        $articles = Article::query()->where('created_at', '<',  Carbon::now()->subDays(3))->where('new', 1)->update(['new' => 0]);
//        dd($articles);

//        $filePath = storage_path('app/public/'.$request->image);
//
//            File::delete($filePath);

//            Storage::delete('public/images/B1V23V3DPZQqsXcwsp7XLCkm3j2K4y9OxvJ0bjj7.png');
//
//            dd(1);
//        Auth::logout(auth()->user());
//        return 1;
        $articles = Article::latest()->where('user_id', auth()->user()->id)->paginate(10);

        return view('admin.admin', ['articles' => $articles]);
    }
}
