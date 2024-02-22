@extends('layouts.adm')
@section('title', 'Пост')


@section('content') 
<div class="d-flex align-items-center justify-content-between">
<h1>{{$post->title}}</h1>

<div class="mr-5">
    <form action="{{route('adm.users.delete', $post->id)}}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger">Удалить этот пост</button>
    </form>
</div>
</div>

<div class="container w-25">
<img src="{{asset($post->img)}}" class="card-img-top" alt="...">
    {{$post->content}}
</div>

@endsection