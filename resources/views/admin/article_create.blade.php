@extends('layouts.base')

@section('content')
    <div class="d-flex justify-content-center p-5">
        <div class="w-50">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h2>{{$title}}</h2>
            <form action="{{route('article.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" id="title">
                </div>
                <div class="input-group">
                    <span class="input-group-text">Text</span>
                    <textarea name="text" class="form-control"></textarea>
                </div>
                <div class="input-group mb-3">
                    <div>Photo</div>
                        <input name="image" type="file" class="form-control" id="image">
                        <label class="input-group-text" for="image">Upload</label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
