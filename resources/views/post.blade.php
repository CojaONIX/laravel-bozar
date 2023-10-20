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

    <div class="row row-cols-1">
        <div class="card-group">
            <div class="card">

                @isset($post->image)
                    <img src="{{asset('storage/' . $post->image)}}" class="card-img-top" alt="...">
                @else
                    <img src="https://picsum.photos/id/{{$post->id}}/300/100.jpg" class="card-img-top" alt="...">
                @endisset

                <div class="card-header">
                    @foreach($post->categories as $category)
                    <span class="badge rounded-pill text-bg-warning">{{$category->name}}</span>
                    @endforeach
                </div>

                <div class="card-body">
                    <p class="card-text">Author: {{$post->user->name}} - PostID: {{$post->id}}<small class="text-muted float-end">{{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</small></p>
                    <h3 class="card-title">{{$post->title}}</h3>
                    <p class="card-text">{{$post->body}}</p>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <h4 id="averageRating">
                    @if($post->rate > 0)
                        {{number_format($post->rate, 2)}}
                    @endif
                    </h4>

                    @auth
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
                    @endauth
                    @guest
                        <p>Please login to rate</p>    
                    @endguest

                    <div>
                        <div id="rates_count" class="d-flex justify-content-between">
                            @foreach(range(1, 5) as $rate)
                                @isset($sett['rates_count'][$rate])
                                    <span class="badge text-bg-light mx-1">{{$rate}}: {{$sett['rates_count'][$rate]}}</span>
                                @else
                                    <span class="badge text-bg-light mx-1">{{$rate}}: 0</span>
                                @endisset
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ url()->previous() }}" class="btn btn-primary">Back to Home</a>
                </div>
            </div>
        </div>
    </div>

    <pre id="info"></pre>

@endsection

@section('JavaScript')
<script>
    $(document).ready(function() {
        
        rate = {{$sett['rate']}};
        if(rate > 0) {
            $('.rate').eq(rate).removeClass('text-bg-light');
            $('.rate').eq(rate).addClass('text-bg-primary');
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
                    //$('#info').text(JSON.stringify(data));
                    $('#averageRating').text(data.sett.rates_avg);
                    $('#rates_count span').text(0);
                    $.each(data.sett.rates_count, function( key, value ) {
                        $('#rates_count span').eq(key-1).text(value);
                    });
                },
                error: function (data) {
                    $('#info').text(JSON.stringify(data, undefined, 2));
                }
            });

        });

    });
</script>
@endsection