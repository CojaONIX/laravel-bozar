<div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 150px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">{{Auth::user()->role_id}}</span></a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto" id="menu">
        <li><a href="{{Route('dashboard')}}" class="nav-link text-white">Home</a></li>
        <li><a href="{{Route('dashboard.posts')}}" class="nav-link text-white">Posts</a></li>
        @if(Auth::user()->role_id != 9)
            <li><a href="{{Route('profiles')}}" class="nav-link text-white">Users</a></li>
            <li><a href="{{Route('dashboard.categories')}}" class="nav-link text-white">Categories</a></li>
        @endif
    </ul>
</div>

<script>
    $("#menu li:nth-child(" + {{$activee}} + ") a").addClass("active");
</script>
