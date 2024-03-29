<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    @yield('add_install')

    <title>BoZar - @yield('title')</title>
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="/">ONIX</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="{{ route('home.page') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('test.page') }}">Test</a></li>

{{--                    <li class="nav-item dropdown">--}}
{{--                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Old</a>--}}
{{--                        <ul class="dropdown-menu">--}}
{{--                            <li><a class="dropdown-item" href="{{ route('old.view.page', ['old_view' => 'welcome']) }}">Welcome</a></li>--}}
{{--                            <li><hr class="dropdown-divider"></li>--}}
{{--                            <li><a class="dropdown-item" href="{{ route('old.view.page', ['old_view' => 'login']) }}">login</a></li>--}}
{{--                            <li><a class="dropdown-item" href="{{ route('old.view.page', ['old_view' => 'register']) }}">register</a></li>--}}
{{--                            <li><a class="dropdown-item" href="{{ route('old.view.page', ['old_view' => 'forgot-password']) }}">forgot-password</a></li>--}}
{{--                            <li><hr class="dropdown-divider"></li>--}}
{{--                            <li><a class="dropdown-item" href="{{ route('old.view.page', ['old_view' => 'confirm-password']) }}">confirm-password</a></li>--}}
{{--                            <li><a class="dropdown-item" href="{{ route('old.view.page', ['old_view' => 'reset-password']) }}">reset-password</a></li>--}}
{{--                            <li><a class="dropdown-item" href="{{ route('old.view.page', ['old_view' => 'verify-email']) }}">verify-email</a></li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}

                    <li class="nav-item"><a class="nav-link" href="{{ route('contact.page') }}">Contact</a></li>
                </ul>

                <form method="get" action="{{ route('search') }}" class="d-flex mx-5" role="search">
                    <input class="form-control me-2" type="search" id="term" name="term" value="{{isset($term) ? $term : ''}}" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>

                @auth
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Hello, {{ Auth::user()->name}}</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
{{--                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>--}}
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="post" action="{{ route('logout') }}" class="dropdown-item">
                                    @csrf
                                    <button class="btn btn-outline-danger col-12" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary mx-3">Login</a>
                @endauth

          </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between">
            <h3 class="my-3">@yield('title')</h3>
            <h6 class="mt-4">@datetime</h6>
        </div>
        <hr>
        @yield('content')

    </div>

    @yield('JavaScript')
</body>
</html>
