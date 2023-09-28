@extends('layouts.blog')

@section('title', 'New Post')
 
@section('content')

    <form method="post" action="/dashboard/post/new">
        @csrf

        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="title" name="title" placeholder="Title:">
            <label for="title">Title:</label>
        </div>
        <div class="form-floating">
            <textarea class="form-control" placeholder="Body:" id="body" name="body" style="height: 500px"></textarea>
            <label for="body">Body:</label>
        </div>
        
        <button class="btn btn-outline-primary col-12 my-3" type="submit">Save</button>
    </form>

@endsection

