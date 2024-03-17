@extends('layouts.base')


@section('content')

    <div class="container p-3">
        <div class="row">
            <div class="col-lg-9">
                <div class="d-flex flex-column bd-highlight mb-3">
                    @foreach($articles as $article)
                        <a href="{{route('article', ['id' => $article->id])}}">
                            <div class="card mb-3">
                                @if($article->new)
                                 <span class="badge bg-danger position-absolute top-0 start-100 translate-middle fs-6">NEW</span>
                                @endif
                                @if($article->image)
                                    <img src="@if(str_contains($article->image, 'http')) {{$article->image}} @else {{asset('storage/'. $article->image)}} @endif" class="card-img-top" alt="...">
                                @endif
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
