@extends('layouts.blog')

@section('title', 'Post')

@section('add_install')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <style>
        .rate {
            cursor: pointer;
        }
    </style>
@endsection
 
@section('content')
    @auth
        <div class="d-flex justify-content-between col-lg-3">
            <div>
                <h2 id="averageRating">0.00</h2>
            </div>
            <div>
                <div class="d-flex justify-content-between">
                    <span class="rate badge text-bg-light text-danger mx-1">X</span>
                    <span class="rate badge text-bg-light mx-1">1</span>
                    <span class="rate badge text-bg-light mx-1">2</span>
                    <span class="rate badge text-bg-light mx-1">3</span>
                    <span class="rate badge text-bg-light mx-1">4</span>
                    <span class="rate badge text-bg-light mx-1">5</span>
                </div>
            </div>
        </div>
        <pre id="info">{}</pre>
    @endauth
    @guest
        <p>Please login to rate</p>    
    @endguest

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
    $(document).ready(function() {
        
        rate = {{$sett['rate']}};
        if(rate > 0) {
            $('.badge').eq(rate).removeClass('text-bg-light');
            $('.badge').eq(rate).addClass('text-bg-primary');
        }

        $('.rate').click(function(){
            $('.rate').removeClass('text-bg-primary');
            $('.rate').addClass('text-bg-light');
            $(this).removeClass('text-bg-light');
            $(this).addClass('text-bg-primary');

            $.ajax({
                type: 'POST',
                url: '/ajax/post/rate',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    post_id: {{$post->id}},
                    rate: $(this).index()
                },
                success: function (data) {
                    $('#info').text(JSON.stringify(data));
                    $('#averageRating').text(data.response);
                    

                },
                error: function (data) {
                    $('#info').text(JSON.stringify(data, undefined, 2));

                }
            });

        });

    });
</script>
@endsection