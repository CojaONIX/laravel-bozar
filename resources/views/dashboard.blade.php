@extends('layouts.blog')

@section('title', 'Dashboard')
 
@section('content')

    <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.js"></script>

    <a href="" class="btn btn-primary my-5">New Post</a>

    <table id="example" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Body</th>
                <th>created_at</th>
                <th>updated_at</th>
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
            </tr>
            @endforeach

        </tbody>
    </table>

    <script>
        $('#example').DataTable();
    </script>
@endsection

