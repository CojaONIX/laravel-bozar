@extends('layouts.blog')

@section('title', 'Home')

@section('content')

    <div class="row justify-content-start">
        <div class="dropdown my-3 col-2">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">{{$selected_author}}</button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item d-flex justify-content-between" href="/">All authors <span class="badge text-bg-dark ms-3">{{$authors->sum('posts_count')}}</span></a></li>
            @foreach($authors as $author)
                <li><a class="dropdown-item d-flex justify-content-between" href="/posts/{{$author->id}}">{{$author->name}} <span class="badge text-bg-secondary ms-3">{{$author->posts_count}}</span></a></li>
            @endforeach
            </ul>
        </div>
        @isset($term)
        <div class="dropdown my-3 col-6">
            <div class="alert alert-warning my-0 py-1" role="alert">Search by: "{{$term}}"</div>
        </div>
        @endisset
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse($posts as $post)
        <div class="card-group">
            <div class="card">

                @if(Str::length($post->image) > 3)
                    <img src="{{asset('storage/posts/' . $post->image)}}" class="card-img-top" alt="...">
                @else
                    <img src="https://picsum.photos/id/{{$post->image}}/300/100.jpg" class="card-img-top" alt="...">
                @endif

                <div class="card-header">
                    @foreach($post->categories as $category)
                    <span class="badge rounded-pill text-bg-warning">{{$category->name}}</span>
                    @endforeach
                </div>

                <div class="card-body">
                    <p class="card-text">{{$post->user->name}}<small class="text-muted float-end">{{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</small></p>
                    <h3 class="card-title">{{$post->title}}</h3>
                    <p class="card-text">{{ \Illuminate\Support\Str::limit($post->body, 300, $end='...') }}</p>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <h4>
                    @if($post->rate > 0)
                        {{number_format($post->rate, 2)}}
                    @endif
                    </h4>
                    <a href="{{ route('post.page', ['slug' => $post->slug]) }}" class="btn btn-primary">Read more...</a>
                </div>
            </div>
        </div>
        @empty
            <div class="alert alert-warning" role="alert">No posts found</div>
        @endforelse
    </div>

    <hr>
    <div class="row">{{ $posts->links() }}</div>

    <hr>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
            {{session('success')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <hr>

@endsection
