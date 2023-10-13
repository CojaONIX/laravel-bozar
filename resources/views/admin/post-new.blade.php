@extends('layouts.blog')

@section('title', 'New Post')

@section('add_install')
    <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.js"></script>
@endsection
 
@section('content')

<div class="d-flex flex-nowrap">

    <x-sidebar/>

    <div class="col-8 m-5">
        <form method="post" action="/dashboard/post/new" enctype="multipart/form-data">
            @csrf

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="title" name="title" placeholder="Title:" autofocus value="{{ old('title') }}">
                <label for="title">Title:</label>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" placeholder="Body:" id="body" name="body" style="height: 200px">{{ old('body') }}</textarea>
                <label for="body">Body:</label>
            </div>

            <div class="mb-3">
                <label class="form-label" for="image">Image:</label>
                <input type="file" class="form-control" id="image" name="image" value="{{ old('image') }}">
            </div>

            <div class="mb-3">
                <label for="categories">Choose categoeies:</label>
                <select class="form-select" id="categories" name="categories[]" multiple aria-label="multiple select example">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
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

<script>
    $("#menu li:nth-child(2) a").addClass("active");
</script>
@endsection

