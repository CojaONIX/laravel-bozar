@extends('layouts.blog')

@section('title', 'Dashboard')
 
@section('content')

    <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.js"></script>

    <a href="/dashboard/post/new" class="btn btn-primary my-5">New Post</a>

    <table id="example" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Body</th>
                <th>created_at</th>
                <th>updated_at</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <td>{{$post->id}}</td>
                <td>{{$post->title}}</td>
                <td>{{ \Illuminate\Support\Str::limit($post->body, 100, $end='...') }}</td>
                <td>{{$post->created_at}}</td>
                <td>{{$post->updated_at}}</td>
                <td><a href="/dashboard/post/edit/{{$post->id}}" class="btn btn-outline-primary">Edit</a></td>
                <td>
                    <form method="post" action="/dashboard/post/delete/{{$post->id}}">
                        @csrf
                        @method('delete')
                        <button class="btn btn-outline-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show my-4" role="alert">
            {{session('success')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <script>
        $('#example').DataTable();
    </script>
@endsection

