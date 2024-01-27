@extends('layouts.adm')

@section('title', 'Posts Page')
@section('back')
    <a href="{{route('adm.users.index')}}"><- Назад</a>
@endsection

@section('content') 
<h1>Posts of {{$user->name}}</h1>
<form action="{{route('adm.users.searchPost', $user->id)}}" method="get">

    <div class="input-group mb-3">
        <input type="text" name="search" class="form-control" placeholder="Search" aria-label="Username"
            aria-describedby="basic-addon1">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>

</form>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">category</th>


        </tr>
    </thead>
    <tbody>
        @for($i = 0; $i<count($posts); $i++) 
        <tr>
            <td scope="row">{{$i+1}}</td>
            <td><a href="{{route('adm.users.showUserPosts', $posts[$i]->id)}}">{{$posts[$i]->title}}</a></td>
            <td>{{$posts[$i]->category->name}}</td>
        </tr>
        @endfor
    </tbody>
</table>
@endsection