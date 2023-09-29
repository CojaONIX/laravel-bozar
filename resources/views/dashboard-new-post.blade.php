@extends('layouts.blog')

@section('title', 'New Post')
 
@section('content')

    <form method="post" action="/dashboard/post/new">
        @csrf

        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="title" name="title" placeholder="Title:" autofocus value="{{ old('title') }}">
            <label for="title">Title:</label>
        </div>
        <div class="form-floating">
            <textarea class="form-control" placeholder="Body:" id="body" name="body" style="height: 500px">{{ old('body') }}</textarea>
            <label for="body">Body:</label>
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
@endsection

