@extends('layouts.base')

@section('content')

    <div class="d-flex justify-content-center p-5">

        <div class="w-50">
            <div id="errors"></div>
{{--            @if ($errors->any())--}}
{{--                <div class="alert alert-danger">--}}
{{--                    <ul>--}}
{{--                        @foreach ($errors->all() as $error)--}}
{{--                            <li>{{ $error }}</li>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            @endif--}}
            <h2>{{$title}}</h2>
            <form action="{{route('article.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" id="title">
                </div>
                <div class="input-group">
                    <span class="input-group-text">Text</span>
                    <textarea name="text" class="form-control" id="text"></textarea>
                </div>
                <div class="input-group mb-3">
                    <div>Photo</div>
                        <input name="image" type="file" class="form-control" id="image">
                        <label class="input-group-text" for="image">Upload</label>
                </div>
                <button id="submitBtn" type="button" class="btn btn-primary">Submit</button>
{{--                <button id="submitBtn" type="submit" class="btn btn-primary">Submit</button>--}}
            </form>
        </div>
    </div>


    <script>

        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        function create() {

            let title = document.getElementById("title");
            let text = document.getElementById("text");
            // let is_new = document.getElementById("is_new");
            let image = document.getElementById("image");
            let file = image.files[0];

            let formData = new FormData();

            formData.append('title', title.value);
            formData.append('text', text.value);
            if(file !== undefined){
                formData.append('image', file);
            }

            fetch("{{route('article.store')}}", {
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
                        window.location.href = dataJSON.url;
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }

        document.getElementById("submitBtn").addEventListener("click", create);

    </script>
@endsection
