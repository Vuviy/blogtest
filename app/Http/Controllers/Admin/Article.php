<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use function Symfony\Component\String\u;

class Article extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create';

        return view('admin.article_create', ['title' => $title]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {





//        $data = $request->validate([
//            'title' => 'required|min:5|max:70',
//            'text' => 'required|min:5',
//            'image' => 'image',
//        ]);

//        dd($request->all());


//        dd(url()->current());

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5|max:70',
            'text' => 'required|min:5',
            'image' => 'image',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = ['title' => $request->title, 'text' => $request->text, 'new' => 1, 'user_id' => auth()->user()->id];
//        dd($data);

        if($request->hasFile('image')){

            $file = $request->file('image')->store('images', 'public');
            $data['image'] = $file;
        }

        $article = \App\Models\Article::query()->create($data);


        Log::channel('crud')->info('Article created', ['user:' => auth()->user()->id, 'article id:' => $article->id]);

//        $title = 'Edit';

        return response()->json(['success' => true, 'url' =>  url()->current().'/'. $article->id. '/edit'], 202);

//        return redirect()->route('article.edit', ['article' => $article, 'title' => $title]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $article = \App\Models\Article::query()->find($id);
//        $title = 'Edit';
//
//        return view('admin.article', ['article' => $article, 'title' => $title]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = \App\Models\Article::query()->find($id);
        if (! Gate::allows('crud', $article)) {
            abort(403);
        }

        $title = 'Edit';

        return view('admin.article_edit', ['article' => $article, 'title' => $title]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

//        dd($request->all());

//        $validator = Validator::make($request->all(), [
//            'title' => 'required|min:5|max:70|string',
//            'text' => 'required|min:5|string',
//            'id' => 'required',
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json(['errors' => $validator->errors()], 422);
//        }
        $article = \App\Models\Article::query()->find($id);

        if (! Gate::allows('crud', $article)) {
            abort(403);
        }

        $request->validate(
            [
            'title' => 'required|min:5|max:70|string',
            'text' => 'required|min:5|string',
        ]);

        if(!$article){
            return response()->json(['message' => 'Article not found'], 404);
        }

        $data = ['title' => $request->title, 'text' => $request->text, 'new' => 0];
        if($request->is_new){
            $data['new'] = 1;
        }

        if($request->hasFile('image')){

            Storage::delete('public/'.$article->image);
            $file = $request->file('image')->store('images', 'public');
            $data['image'] = $file;
        }

        $article->update($data);


        Log::channel('crud')->info('Article updated', ['user:' => auth()->user()->id, 'article id:' => $article->id]);
        $title = 'Edit';

        return redirect()->route('article.edit', ['article' => $article, 'title' => $title]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article =  \App\Models\Article::query()->find($id);

        if (! Gate::allows('crud', $article)) {
            abort(403);
        }
        Storage::delete('public/'.$article->image);
        $article->delete();
        Log::channel('crud')->info('Article deleted', ['user:' => auth()->user()->id, 'article id:' => $article->id]);

        $articles = \App\Models\Article::latest()->where('user_id', auth()->user()->id)->paginate(10);

//        return view('admin.admin', ['articles' => $articles]);
        return redirect()->route('admin');
    }

    public function deleteImage(Request $request)
    {
        $article =  \App\Models\Article::query()->find($request->id);

        if (! Gate::allows('crud', $article)) {
            abort(403);
        }
        Storage::delete('public/'.$article->image);
        $article->update(['image' => null]);
        Log::channel('crud')->info('Image deleted', ['user:' => auth()->user()->id, 'article id:' => $article->id]);
        return response()->json(['success' => true, 'message' => 'Deleted'], 202);
    }
}
