@extends('layouts.adm')

@section('title', 'Posts Page')

@section('content') 
<h1>Все посты</h1>
<form action="{{route('adm.posts.search')}}" method="get">

    <div class="input-group mb-3">
        <input type="text" name="search" class="form-control" placeholder="Search" aria-label="Username"
            aria-describedby="basic-addon1">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>

</form>
@if(session('error'))
<div class="alert alert-danger">
{{session('error')}}
</div>
@endif

<table class="table">
    <thead>
        <tr>
          
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">category</th>
            <th scope="col">Users</th>
            <th scope="col">Rates</th>


        </tr>
    </thead>

    @csrf 
    @method('DELETE')
    <tbody>
        @for($i = 0; $i<count($posts); $i++) 
        <tr>

          
            <td scope="row">{{$i+1}}</td>
            <td><a href="{{route('adm.users.showUserPosts', $posts[$i]->id)}}">{{$posts[$i]->title}}</a></td>
            <td>{{$posts[$i]->category->name}}</td>
            <td>{{$posts[$i]->user->name}}</td>
            <td>{{$posts[$i]->user->name}}</td>
        </tr>
        @endfor
    </tbody>
</table>
{{ $posts->links() }}
<!-- @if(count($posts)>0)
<button type="submit" class="btn btn-outline-danger">
    Delete
</button>
@endif -->


@endsection