@extends('layouts.blog')

@section('title', 'New Categpry')

@section('add_install')
    <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.js"></script>
@endsection
 
@section('content')

<div class="d-flex flex-nowrap">

    <x-sidebar :activee="$activee"/>

    <div class="col-8 m-5">

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
    </div>

</div>

@endsection

