@extends('layouts.app')

@section('title', 'CREATE PAGE')

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
<main class="border w-100 d-flex justify-content-center">
<div class="container">
    <h2><a href="{{ route('posts.index') }}" class="btn btn-primary">Home</a></h2>
    <h1>Create a new post for students</h1>

    <form action="{{ route('posts.store') }}" method="post" class="mt-3" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" name="title" id="title" placeholder="Enter the title" class="form-control">
        </div>

        <div class="mb-3">
            <label for="post" class="form-label">Post:</label>
            <textarea name="content" id="post" cols="30" rows="10" placeholder="Write your post here"
                class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="cat" class="form-label">Categories:</label>
            <select name="category_id" id="cat" class="form-select">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
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

        <button type="submit" class="btn btn-success w-100">Add Post</button>
    </form>
</div>

</main>

@endsection