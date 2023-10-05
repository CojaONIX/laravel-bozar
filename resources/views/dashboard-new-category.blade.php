@extends('layouts.blog')

@section('title', 'New Post')
 
@section('content')

    <form method="post" action="/dashboard/category/new">
        @csrf

        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="name" name="name" placeholder="Name:" autofocus value="{{ old('name') }}">
            <label for="name">Name:</label>
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

