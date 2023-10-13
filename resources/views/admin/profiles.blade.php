@extends('layouts.blog')

@section('title', 'Dashboard')

@section('add_install')
    <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.js"></script>
@endsection
 
@section('content')

<div class="d-flex flex-nowrap">

    <x-sidebar :activee="$activee"/>

    <div class="col-8 m-5">

        <h4>Users</h4>
        <table id="users" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role_id}}</td>
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
    </div>

</div>

    <script>
        $('#users').DataTable({
            lengthMenu: [
                [-1, 10, 25, 50, -1],
                ['All', 10, 25, 50, 'All']
            ]
        });
    </script>
@endsection

