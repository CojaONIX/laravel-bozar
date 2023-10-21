@extends('layouts.blog')

@section('title', 'Dashboard')

@section('add_install')
    <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-1.13.6/datatables.min.js"></script>
@endsection
 
@section('content')

<div class="d-flex flex-nowrap">

    <x-sidebar :active="$sett['sidebarActive']"/>

    <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Hi, {{Auth::user()->name}}</h1>
          <p class="lead">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repellendus ratione dignissimos illo animi numquam vitae iure nemo, commodi maxime quibusdam velit ipsam, ab excepturi fuga distinctio, sit itaque debitis aperiam rerum accusamus consequatur ad iste tenetur a? Laudantium amet, totam libero quas architecto pariatur sit quia voluptatum. Nulla excepturi eos voluptatum provident vero qui iure est neque pariatur numquam et, ducimus quaerat doloribus? Libero atque velit dolorum fugiat doloremque ad, doloribus quo itaque? Facere amet, dignissimos eius enim repudiandae cum porro at fuga quod temporibus dolor officiis dicta assumenda fugit sapiente. Quidem inventore eos dolorem voluptatum unde fugit praesentium explicabo iste assumenda impedit recusandae necessitatibus ipsa iure quam, omnis deleniti perferendis minus fugiat. Provident, quos placeat amet totam illum porro sunt fuga obcaecati, iusto quibusdam odit quo praesentium quisquam repellendus mollitia corrupti ab inventore enim officia libero iste debitis velit veniam nostrum? Nobis, odio officia minus excepturi dicta nulla nesciunt ipsa amet ab perspiciatis iure incidunt temporibus. Illum at vel, ratione nisi culpa excepturi id. Quo vero enim earum quam impedit tempora eveniet ab suscipit dolores id totam laboriosam vel quia, eligendi numquam a qui sit, dignissimos sequi magni laborum dolore consequatur. Commodi at, suscipit quaerat ad quidem tempore blanditiis maiores, perferendis quam mollitia possimus eum velit earum culpa? Optio aliquid saepe, doloribus hic quas aut amet labore adipisci quidem iusto, est, ratione illum vel laborum recusandae aperiam provident obcaecati quod repellendus! Magni unde repudiandae, corporis cum deserunt perferendis voluptates, sapiente possimus deleniti ab rem expedita aliquid. Ut amet corporis nam placeat asperiores dignissimos? Iusto et dolorem modi! Quos ea blanditiis eveniet obcaecati nam, sunt quasi at expedita sit ipsa libero error repellat eos accusantium nulla tenetur maxime vel voluptatum? Impedit quod sapiente earum labore reiciendis, nam perferendis neque ullam voluptatem exercitationem officia ea beatae, quae laudantium provident quas soluta.</p>
        </div>
      </div>
</div>

@endsection

