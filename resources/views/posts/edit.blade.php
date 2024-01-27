@extends('layouts.app')

@section('title', 'UPDATE PAGE')

@section('content')
<!-- <aside class="bg-warning w-25 vh-100 d-flex align-items-center justify-content-center">
            <ul class="list-unstyled">
                <li class="fs-1"></li>


            </ul>
        </aside> -->
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<main class="border  w-100 d-flex justify-content-center">
    <div class="">
        <h1>Create new post for students</h1>
        <form action="{{route('posts.update', $post->id)}}" method="post" class="mt-2">

            @csrf
            @method('PUT')
            <div>
                <label for="title" class="form-label">Title:</label>
                <input type="text" name="title" id="title" placeholder="Title" class="form-control border-dark"
                    value="{{$post->title}}">
            </div>
            <div class="mt-4">
                <label for="post" class="form-label">Post:</label>
                <textarea name="content" id="post" cols="30" rows="10" placeholder="post"
                    class="form-control border-dark">{{$post->content}}</textarea>
            </div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div>
                <label for="cat">Categories: </label>
                <select name="category_id" id="cat" class="form-select">

                    @foreach($categories as $category)

                    <option @if($post->category_id == $category->id) selected @endif
                        value="{{$category->id}}">{{$category->name}}</option>

                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success mt-2 w-100">Update</button>

        </form>
    </div>
</main>
</div>
@endsection