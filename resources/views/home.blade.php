@extends('layouts.blog')

@section('title', 'Home')
 
@section('content')
   
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($posts as $post)
        <div class="card-group">
            <div class="card">
                <img src="https://picsum.photos/300/100.jpg?random={{$post->id}}" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text"><small class="text-muted">{{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</small></p>
                    <h3 class="card-title">{{$post->title}}</h3>
                    <p class="card-text">{{ \Illuminate\Support\Str::limit($post->body, 300, $end='...') }}</p>
                </div>

                <div class="card-footer">
                    <a href="/post/{{$post->id}}" class="btn btn-primary float-end">Read more...</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <hr>
    <div class="row">{{ $posts->links() }}</div>
    

@endsection