@extends('layouts.base')


@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="d-flex flex-column bd-highlight mb-3">
                    @foreach($articles as $article)
                        <a href="{{route('article', ['id' => $article->id])}}">
                            <div class="card mb-3">
                                <img src="{{$article->image}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{$article->title}}</h5>
                                    <h5 class="card-title"><span>Author: </span>{{$article->user->name}}</h5>
                                    <p class="card-text">{{mb_substr($article->text, 0, 100)}}...</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                    {{ $articles->links() }}
                </div>
            </div>
            @include('includes.rightbar')
        </div>
    </div>
@endsection()
