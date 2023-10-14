@extends('layouts.blog')

@section('title', 'Post')

@section('add_install')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endsection
 
@section('content')
    <div class="d-flex justify-content-between col-lg-3">
        <div>
            <h2 id="averageRating">0.00</h2>
        </div>
        <div>
            <div class="d-flex justify-content-between">
                <span class="badge text-bg-light text-danger mx-1">X</span>
                <span class="badge text-bg-light mx-1">1</span>
                <span class="badge text-bg-light mx-1">2</span>
                <span class="badge text-bg-light mx-1">3</span>
                <span class="badge text-bg-light mx-1">4</span>
                <span class="badge text-bg-light mx-1">5</span>
            </div>
            <input type="range" class="col-12 px-2 my-2" min="0" max="5" id="rate" value="0">
        </div>
    </div>
    <p id="info">{}</p>

    

    <div class="row mt-5">
        <div class="col-lg-9">
            <p class="card-text"><small class="text-muted">{{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</small></p>
            <h1>{{$post->title}}</h1>
            <p>{{$post->body}}</p>
        </div>

        <div class="col-lg-3">
            <img src="https://picsum.photos/id/{{$post->id}}/300/100.jpg" class="col-12 my-2" alt="...">
            <img src="https://picsum.photos/id/{{$post->id + 1}}/300/100.jpg" class="col-12 my-2" alt="...">
        </div>
    </div>


@endsection

@section('JavaScript')
<script>
    $('#rate').click(function(){
        $(this).prev().children().removeClass('text-bg-light text-bg-primary');
        if($(this).val() == 0)
            $(this).prev().children().addClass('text-bg-light');
        else
            $(this).prev().children().eq($(this).val()).addClass('text-bg-primary');

        $.ajax({
            type: 'GET',
            url: '/ajax/post/rate',
            dataType: 'json',
            data: {
                val: $(this).val()
            },
            success: function (data) {
                $('#info').text(JSON.stringify(data));
                $('#averageRating').text(data.response);
                

            },
            error: function (data) {
                $('#info').text(JSON.stringify(data));

            }
        });

    });
</script>
@endsection