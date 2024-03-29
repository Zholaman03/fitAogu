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
<div class=" container p-4">
    <h1>Create new post for students</h1>
    <div class="card border-0 shadow p-4">
        <div class="image-container w-50 mb-3">
            <img src="{{ asset($post->img) }}" class="card-img-top" alt="Post Image">
        </div>
    </div>

    <form action="{{ route('posts.update', $post->id) }}" method="post" class="mt-2" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" name="title" id="title" placeholder="Title" class="form-control"
                value="{{ $post->title }}">
        </div>

        <div class="mb-3">
            <label for="post" class="form-label">Post:</label>
            <textarea name="content" id="post" cols="30" rows="10" placeholder="Post"
                class="form-control">{{ $post->content }}</textarea>
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

        <div class="mb-3">
            <label for="cat" class="form-label">Categories:</label>
            <select name="category_id" id="cat" class="form-select">
                @foreach ($categories as $category)
                <option @if ($post->category_id == $category->id) selected @endif
                    value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="img" class="form-label">Upload Image:</label>
            <input type="file" name="img" class="form-control @error('img') is-invalid @enderror">
            @error('img')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success w-100">Update</button>
    </form>
</div>



@endsection