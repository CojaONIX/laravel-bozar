@extends('layouts.blog')

@section('title', 'Contact Form')

@section('content')

    <form method="post" action="{{ route('contact.send') }}">
        @csrf

        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="name" name="name" placeholder="Name:" autofocus value="{{ old('name') }}">
            <label for="name">Name:</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email:" value="{{ old('email') }}">
            <label for="email">Email:</label>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Message:" id="message" name="message" style="height: 200px">{{ old('message') }}</textarea>
            <label for="message">Message:</label>
        </div>

        <button class="btn btn-outline-primary col-12 my-3" type="submit">Send</button>
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
