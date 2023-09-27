<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BoZar - Home</title>
</head>
<body>
    <h1>Home</h1>

    @foreach($posts as $post)
        <h2>{{$post->title}}, {{$post->created_at}}</h2>
        <p>{{$post->body}}</p>
    @endforeach

</body>
</html>