@extends('layouts.blog')

@section('title', 'Edit Post')

@section('add_install')
    <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.js"></script>
@endsection
 
@section('content')

<div class="d-flex flex-nowrap">

    <x-sidebar active=2/>

    <div class="col-8 mx-5">
        <div class="d-flex justify-content-between mb-3">
            <a href="/dashboard/posts" class="btn btn-outline-primary">Cancel</a>

            <form method="post" action="/dashboard/post/delete/{{$post->id}}">
                @csrf
                @method('delete')
                <button class="btn btn-outline-danger" type="submit">Delete</button>
            </form>
        </div>

        <form method="post" action="/dashboard/post/edit/{{$post->id}}" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="title" name="title" placeholder="Title:" value="{{$post->title}}">
                <label for="title">Title:</label>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" placeholder="Body:" id="body" name="body" style="height: 200px">{{$post->body}}</textarea>
                <label for="body">Body:</label>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <div>
                    <label for="categories">Choose categoeies:</label>
                    <select class="form-select" style="height: 200px;" id="categories" name="categories[]" multiple aria-label="multiple select example">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}"{{$category->post_exists ? " selected" : ""}}>{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label" for="image">Image:</label>
                    <input type="file" class="form-control mb-3" id="image" name="image" value="{{ old('image') }}">
                </div>
            </div>
            
            <button class="btn btn-outline-primary col-12 my-3" type="submit">Save</button>
        </form>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

</div>

@endsection

