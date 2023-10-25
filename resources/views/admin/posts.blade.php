@extends('layouts.blog')

@section('title', 'Dashboard')

@section('add_install')
    <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.js"></script>
@endsection
 
@section('content')

<div class="d-flex flex-nowrap">

    <x-sidebar :active="$sett['sidebarActive']"/>

    <div class="m-3">

        <div class="d-flex justify-content-between align-items-start">
            <a href="/dashboard/post/new" class="btn btn-primary my-4">New Post</a>

            <div id="ajaxAlert" class="alert alert-success d-none" role="alert">
                <span id="ajaxMsg"></span>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session('success')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif   
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
                    <th></th>
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
                        @if($post->image)
                            <img src="{{asset('storage/posts/' . $post->image)}}" height="30">
                        @endif
                    </td>

                    <td>{{$post->created_at}}</td>
                    <td>{{$post->updated_at}}</td>
                    @if($post->trashed())
                        <td><button class="publish btn btn-outline-secondary" data-post={{$post->id}}>Publish</button></td>
                    @else
                        <td><button class="publish btn btn-outline-warning" data-post={{$post->id}}>Unpublish</button></td>
                    @endif

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

    $('.publish').click(function() {
        btn = $(this);
        $.ajax({
            type: 'POST',
            url: '/ajax/post/publish',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                post_id: $(this).data('post')
            },
            success: function (data) {
                btn.toggleClass('btn-outline-secondary btn-outline-warning');
                btn.text(btn.text() == 'Publish' ? 'Unpublish' : 'Publish');
                $('#ajaxMsg').text(data.sett.msg);
                $('#ajaxAlert').removeClass('d-none').fadeIn(1000).delay(2000).fadeOut(1000);
            },
            error: function (data) {
                $('#info').text(JSON.stringify(data, undefined, 2));
            }
        });
    });
</script>
@endsection

