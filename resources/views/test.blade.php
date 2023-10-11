@extends('layouts.blog')

@section('title', 'Test')
 
@section('content')

<pre>
<?php echo json_encode($object, JSON_PRETTY_PRINT);?>
</pre>

@endsection