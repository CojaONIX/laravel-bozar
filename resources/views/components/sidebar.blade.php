<div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 150px;">
    <p class="text-white">{{Auth::user()->role_id}}</p>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto" id="menu">
        <li><a href="{{Route('dashboard')}}" class="nav-link text-white{{$active == 1 ? ' active' : ''}}">Home</a></li>
        <li><a href="{{Route('dashboard.posts')}}" class="nav-link text-white{{$active == 2 ? ' active' : ''}}">Posts</a></li>
        @if(Auth::user()->role_id < 6)
            <li><a href="{{Route('profiles')}}" class="nav-link text-white{{$active == 3 ? ' active' : ''}}">Users</a></li>
            <li><a href="{{Route('dashboard.categories')}}" class="nav-link text-white{{$active == 4 ? ' active' : ''}}">Categories</a></li>
        @endif
    </ul>
</div>
