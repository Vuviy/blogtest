@extends('layouts.base')

@section('content')
    <div class="d-flex justify-content-center p-5">
        <div class="w-50">
            <h2>{{$title}}</h2>
            <div id="errors"></div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{route('article.update', ['article' => $article->id])}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{$article->title}}">
                </div>
                <div class="input-group">
                    <span class="input-group-text">Text</span>
                    <textarea name="text" id="text" class="form-control">{{$article->text}}</textarea>
                </div>

                <div class="mb-3 form-check">
                    <input name="is_new" type="checkbox" class="form-check-input" id="is_new" @if($article->new) checked @endif>
                    <label class="form-check-label" for="is_new">NEW</label>
                </div>

                <div class="input-group mb-3">
                    <div>Photo</div>
                        <input name="image" type="file" class="form-control" id="image">
                        <label class="input-group-text" for="image">Upload</label>
                </div>

                <div class="input-group mb-3 photo">
                    <div id="img">
                        @if($article->image)
                        <h3>Photo</h3>
                        <img  class="img-fluid" src=" @if(str_contains($article->image, 'http')) {{$article->image}} @else {{asset('storage/'. $article->image)}} @endif" alt="">
                    </div>
                    @endif
                </div>
                    @if($article->image)
                        <button type="button" class="btn btn-danger" id="deleteImg">Detele Image</button>
                    @endif
                <button type="submit" id="submitBtn" class="btn btn-primary">Submit</button>
{{--                <button type="button" id="submitBtn" class="btn btn-primary">Submit</button>--}}
            </form>
        </div>
    </div>

    <script>
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let deleteBtn = document.getElementById("deleteImg");


        function deleteImg() {

            let formData = new FormData();
            formData.append('id', {{$article->id}});

            fetch("{{route('deleteImage')}}", {
                method: 'POST',
                headers: {
                    // 'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': token
                },
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    let dataJSON = JSON.parse(data);
                    if (dataJSON.errors) {
                        let errorsHtml = '<ul>';
                        for (let errorKey in dataJSON.errors) {
                            errorsHtml += '<li>' + dataJSON.errors[errorKey] + '</li>';
                        }
                        errorsHtml += '</ul>';
                        document.getElementById('errors').innerHTML = errorsHtml;
                    } else {

                        let photo = document.getElementById("img");

                        photo.remove();
                        deleteBtn.remove()
                        alert(dataJSON.message);
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }


            if(deleteBtn){
                deleteBtn.addEventListener("click", deleteImg);
            }


        {{--function edit() {--}}

        {{--    let title = document.getElementById("title");--}}
        {{--    let text = document.getElementById("text");--}}
        {{--    let is_new = document.getElementById("is_new");--}}
        {{--    let image = document.getElementById("image");--}}
        {{--    let file = image.files[0];--}}

        {{--    let formData = new FormData();--}}

        {{--    formData.append('title', title.value);--}}
        {{--    formData.append('text', text.value);--}}
        {{--    formData.append('is_new', is_new.checked);--}}
        {{--    // formData.append('_method', 'PUT');--}}
        {{--    if(file !== undefined){--}}
        {{--        formData.append('image', file);--}}
        {{--    }--}}
        {{--    formData.append('id', {{$article->id}});--}}
        {{--    // console.log(formData);--}}

        {{--    fetch("{{route('article.update', ['article' => $article->id])}}", {--}}
        {{--    --}}{{--fetch("{{route('article.update', ['article' => $article->id])}}", {--}}
        {{--        method: 'PUT',--}}
        {{--        headers: {--}}
        {{--            'Content-Type': 'multipart/form-data',--}}
        {{--            // 'Content-Type': 'application/x-www-form-urlencoded',--}}
        {{--            'X-CSRF-TOKEN': token--}}
        {{--        },--}}
        {{--        body: formData--}}
        {{--    })--}}
        {{--        .then(response => response.text())--}}
        {{--        .then(data => {--}}
        {{--            let dataJSON = JSON.parse(data);--}}
        {{--            if (dataJSON.errors) {--}}
        {{--                let errorsHtml = '<ul>';--}}
        {{--                for (let errorKey in dataJSON.errors) {--}}
        {{--                    errorsHtml += '<li>' + dataJSON.errors[errorKey] + '</li>';--}}
        {{--                }--}}
        {{--                errorsHtml += '</ul>';--}}
        {{--                document.getElementById('errors').innerHTML = errorsHtml;--}}
        {{--            } else {--}}

        {{--                // let photo = document.getElementById("img");--}}
        {{--                //--}}
        {{--                // photo.remove();--}}
        {{--                // alert(dataJSON.message);--}}
        {{--            }--}}
        {{--        })--}}
        {{--        .catch(error => {--}}
        {{--            console.error(error);--}}
        {{--        });--}}
        {{--}--}}

        {{--document.getElementById("submitBtn").addEventListener("click", edit);--}}


    </script>

@endsection
