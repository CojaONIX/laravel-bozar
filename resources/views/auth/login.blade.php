@extends('layouts.blog')

@section('title', 'Login')
 
@section('content')

<ul>
    @foreach($users as $user)
        <li>{{$user->email}}</li>
    @endforeach
</ul>
<div class="row d-flex justify-content-center">
    <div class="col-lg-6 col-xl-4">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="text" name="email" class="form-control" id="email" value="{{ old('email') }}" autofocus>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password">
            </div>

            <button class="btn btn-outline-primary col-12 my-3" type="submit">Login</button>
        </form>
    </div>
</div>
    
@endsection