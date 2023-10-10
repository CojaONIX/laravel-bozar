@extends('layouts.blog')

@section('title', 'Forgot Password')
 
@section('content')

<div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
    <div class="card">
        <div class="card-header">
            <p>Forgot your password?</p>
            <p>No problem.</p>
            <p>Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group mb-3">
                    <label for="email">Email <span class="text-danger">* </span></label>
                    <input type="text" class="form-control my-5" name="email" id="email" value="{{ old('email') }}" autofocus>
                </div>

                <input type="submit" value="Email Password Reset Link" class="btn btn-primary form-control">
            </form>
        </div>

        <div class="card-footer">
            <x-input-error :messages="$errors->get('email')" class="my-2 text-danger" />
            <!-- Session Status -->
            <x-auth-session-status class="my-2 text-success"  :status="session('status')" />
        </div>

    </div>
</div>

@endsection