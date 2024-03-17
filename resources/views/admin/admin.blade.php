@extends('layouts.base')

@section('content')
    <div class="container-fluid">
        <div class="row p-5">
            <div class="col-md-3 bg-light">
                <h2 class="text-center mb-4">Panel</h2>
                <ul class="list-group">
                    <li  class="link-primary list-group-item"><a  class="link-primary" href="{{route('article.create')}}">Add article</a></li>
                </ul>
            </div>
            <div class="col-md-9">
                <h1 class="text-center mb-4">Dashboard</h1>
                <div class="d-flex flex-column bd-highlight mb-3">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($articles as $article)
                                    <tr>
                                        <th scope="row">{{$article->id}}</th>
                                        <td><a href="{{route('article.edit', ['article' => $article->id])}}">{{$article->title}}</a></td>
                                        <td>
                                            <form method="POST" action="{{route('article.destroy', ['article' => $article->id])}}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit">delete</button>
                                            </form>
                                        </td>
                                     </tr>
                                @endforeach
                            </tbody>
                        </table>
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
