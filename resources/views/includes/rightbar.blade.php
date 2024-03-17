

<div class="col-lg-3">
    <h3>Most comments</h3>
    <div class="list-group">

        @foreach($mostComment as $article)

            <a href="{{route('article', ['id' => $article->id])}}">
                <div class="d-flex justify-content-center">
                    <div class="d-flex flex-column bd-highlight mb-1">
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
                                <p class="card-text">{{mb_substr($article->text, 0, 75)}}...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>






