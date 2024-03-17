@extends('layouts.base')


@section('content')
    <div class="d-flex justify-content-center">
        <div class="d-flex flex-column bd-highlight mb-3 w-50 p-5">
            <div class="card mb-3">
                @if($article->image)
                    <img src="@if(str_contains($article->image, 'http')) {{$article->image}} @else {{asset('storage/'. $article->image)}} @endif" class="card-img-top" alt="...">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{$article->title}}</h5>
                    <h5 class="card-title"><span>Author: </span>{{$article->user->name}}</h5>
                    <p class="card-text">{{$article->text}}</p>
                </div>
            </div>

                <h2>Comments:</h2>
            <div class="comments-div" id="myDiv">
                @foreach($article->comments as $comments)
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-text">Author: {{$comments->author}}</p>
                        <h5 class="card-title">{{$comments->text}}</h5>
                    </div>
                </div>
                @endforeach
            </div>
            <div>
                <div id="errors"></div>
                <h3>Send your comment</h3>
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name">
                    </div>
                    <div class="mb-3">
                        <label for="text" class="form-label">Text</label>
                        <input type="text" class="form-control" id="text">
                    </div>
                    <button type="button" class="btn btn-primary" id="submitBtn">Send</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function addComment() {
            let name = document.getElementById("name");
            let text = document.getElementById("text");
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            let formData = new FormData();
            formData.append('text', text.value);
            formData.append('name', name.value);
            formData.append('id', {{$article->id}});

            fetch("{{route('addComment')}}", {
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
                        name.value = ''
                        text.value = ''
                        let commentsDiv = document.getElementById("myDiv");
                        let newComment = '<div class="card mb-3"><div class="card-body"><p class="card-text">Author: '+dataJSON.name+'</p><h5 class="card-title">'+dataJSON.text+'</h5></div></div>';
                        commentsDiv.insertAdjacentHTML('afterbegin', newComment);
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }
        document.getElementById("submitBtn").addEventListener("click", addComment);

    </script>
@endsection()
