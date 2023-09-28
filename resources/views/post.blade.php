@extends('layouts.blog')

@section('title', 'Post')
 
@section('content')

    <div class="row mt-5">
        <div class="col-lg-9">
            <p class="card-text"><small class="text-muted">{{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</small></p>
            <h1>{{$post->title}}</h1>
            <p>{{$post->body}}</p>
        </div>

        <div class="col-lg-3">
            <img src="https://picsum.photos/300/300.jpg?random={{$post->id}}" class="col-12 my-2" alt="...">
            <img src="https://picsum.photos/300/300.jpg?random={{$post->id + 1}}" class="col-12 my-2" alt="...">
        </div>
    </div>

@endsection