@extends('layouts.blog')

@section('title', 'Dashboard')

@section('add_install')
    <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.js"></script>
@endsection
 
@section('content')

<div class="d-flex flex-nowrap">

    <x-sidebar active=2/>

    <div class="mx-3">

        <div class="d-flex justify-content-between align-items-start">
            <a href="/dashboard/post/new" class="btn btn-primary mb-5">New Post</a>
            <div id="successMessage" class="alert alert-success" role="alert">
                @if(session('success'))
                    {{session('success')}}
                @endif   
            </div>
        </div>

        <h4>Posts</h4>
        <hr>
        
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
                    <th>Published</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td>{{$post->id}}</td>
                    <td title="{{$post->categories->pluck('name')}}">{{$post->categories->count()}}</td>
                    <td>{{$post->user->name}}</td>
                    <td>{{$post->title}}</td>
                    <td>{{ \Illuminate\Support\Str::limit($post->body, 50, $end='...') }}</td>
                    <td>
                        @if(Str::length($post->image) > 3)
                            <img src="{{asset('storage/posts/' . $post->image)}}" height="30">
                        @endif
                    </td>
                    <td>{{$post->created_at}}</td>
                    <td>{{$post->updated_at}}</td>
                    <td><div class="form-check form-switch d-flex justify-content-center"><input class="published form-check-input" type="checkbox" role="switch" data-post={{$post->id}} @checked(!$post->trashed())></div></td>
                    <td><a href="/dashboard/post/edit/{{$post->id}}" class="btn btn-outline-primary">Edit</a></td>
                </tr>
                @endforeach

            </tbody>
        </table>

        <hr>
<pre id="info"></pre>
    </div>
</div>
@endsection

@section('JavaScript')
<script>
    $(document).ready(function() {
        $('#posts').DataTable({
            lengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, 'All']
            ]
        });
    });

    $('#successMessage').delay(2000).fadeOut(500);
    $('.published').click(function() {
        $.ajax({
            type: 'POST',
            url: '/ajax/post/publish',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                post_id: $(this).data('post')
            },
            success: function (data) {
                $('#successMessage').text(data.sett.msg).fadeIn(100).delay(2000).fadeOut(500);
            },
            error: function (data) {
                $('#info').text(JSON.stringify(data, undefined, 2));
            }
        });
    });
</script>
@endsection

