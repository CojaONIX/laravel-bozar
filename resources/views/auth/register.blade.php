@extends('layouts.blog')

@section('title', 'Register')
 
@section('content')

<div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
    <div class="card">
        <div class="card-header"><h4>REGISTER<a class="btn btn-outline-primary float-end" href="{{ route('login') }}">or Login</a></h4></div>
        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group mb-3">
                    <label for="name">Name <span class="text-danger">* </span></label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" autofocus>
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email <span class="text-danger">* </span></label>
                    <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}">
                </div>

                <div class="form-group mb-3">
                    <label for="password">Password <span class="text-danger">* </span></label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>

                <div class="form-group mb-3">
                    <label for="password_confirmation">Confirm Password <span class="text-danger">* </span></label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                </div>

                <input type="submit" value="Register" class="btn btn-primary form-control">
            </form>
        </div>

        <div class="card-footer">
            <span class="error">errors:</span>
        </div>

    </div>
</div>

@endsection