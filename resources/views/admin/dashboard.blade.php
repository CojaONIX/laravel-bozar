@extends('layouts.blog')

@section('title', 'Dashboard')

@section('add_install')
    <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.js"></script>
@endsection
 
@section('content')

    <a href="/dashboard/post/new" class="btn btn-primary my-3">New Post</a>
    <h4>Posts</h4>
    <table id="posts" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cats</th>
                <th>Author</th>
                <th>Title</th>
                <th>Body</th>
                <TH>Image</TH>
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
                <td title="{{$post->categories->pluck('name')}}">{{$post->categories->count()}}</td>
                
                <td>
                    @if($post->user)
                        {{$post->user->name}}
                    @endif
                </td>

                <td>{{$post->title}}</td>
                <td>{{ \Illuminate\Support\Str::limit($post->body, 100, $end='...') }}</td>

                <td>
                    @if($post->image)
                        <img src="{{'storage/' . $post->image}}" height="30">
                    @endif
                </td>

                <td>{{$post->created_at}}</td>
                <td>{{$post->updated_at}}</td>
                @if($post->trashed())
                    <td>
                        <form method="post" action="/dashboard/post/restore/{{$post->id}}">
                            @csrf
                            @method('patch')
                            <button class="btn btn-outline-secondary" type="submit">Show</button>
                        </form>
                    </td>

                @else
                    <td><a href="/dashboard/post/edit/{{$post->id}}" class="btn btn-outline-primary">Edit</a></td>
                @endif

                <td>
                    <form method="post" action="/dashboard/post/delete/{{$post->id}}">
                        @csrf
                        @method('delete')
                        @if($post->trashed())
                            <button class="btn btn-outline-danger" type="submit">Delete</button>
                        @else
                            <button class="btn btn-outline-warning" type="submit">Hidde</button>
                        @endif
                        
                    </form>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>

    <hr>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
            {{session('success')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif   
    <hr>

    <a href="/dashboard/category/new" class="btn btn-primary my-3">New Category</a>
    <h4>Categories</h4>
    <table id="categories" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
            </tr>
            @endforeach

        </tbody>
    </table>

    <script>
        $('#categories').DataTable({
            lengthMenu: [
                [-1, 10, 25, 50, -1],
                ['All', 10, 25, 50, 'All']
            ]
        });
        
        $('#posts').DataTable({
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, 'All']
            ]
        });
    </script>
@endsection

