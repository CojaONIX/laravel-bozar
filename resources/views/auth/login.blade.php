@extends('layouts.blog')

@section('title', 'Login')
 
@section('content')

<ul>
    @foreach($users as $user)
        <li>{{$user->email}}</li>
    @endforeach
</ul>

<div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
    <div class="card">
        <div class="card-header">
            <h4>LOGIN<a class="btn btn-outline-primary float-end" href="{{ route('register') }}">or Register</a></h4>
        </div>

        <div class="card-body">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="email">Email <span class="text-danger">* </span></label>
                    <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}" autofocus>
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password <span class="text-danger">* </span></label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <input type="submit" value="Login" class="btn btn-primary form-control">
            </form>
        </div>

        <div class="card-footer">
            <span class="error">errors:</span>
        </div>
    </div>
</div>
    
@endsection