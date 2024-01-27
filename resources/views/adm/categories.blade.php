@extends('layouts.adm')

@section('title', 'Posts Page')
@section('back')
    <a href="{{route('adm.users.index')}}"><- Назад</a>
@endsection

@section('content') 
<h1>Категориялар</h1>
@if(session('message'))
<div class="alert alert-success">
{{session('message')}}
</div>
@elseif ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="{{route('adm.categories.add')}}" method="post">
    @csrf
    <div class="input-group mb-3">
        <input type="text" name="name" class="form-control" placeholder="Добавить категорий" aria-label="Username"
            aria-describedby="basic-addon1">
        
    </div>
    <div class="input-group mb-3 w-25">
        <input type="text" name="code" class="form-control " placeholder="Добавить Код" aria-label="Username"
            aria-describedby="basic-addon1">
    </div>
    <button type="submit" class="btn btn-primary">Добавить</button>
</form>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Категориялар</th>
            <th scope="col">Код</th>


        </tr>
    </thead>
    <tbody>
        @for($i = 0; $i<count($categories); $i++) 
        <tr>
            <td scope="row">{{$i+1}}</td>
            <td>{{$categories[$i]->name}}</td>
            <td>{{$categories[$i]->code}}</td>
        </tr>
        @endfor
    </tbody>
</table>
@endsection