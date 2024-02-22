@extends('layouts.app')

@section('title', 'Show PAGE')

@section('content')
<!-- <a href="{{route('posts.index')}}">GO back</a> -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a href="{{route('posts.index')}}" class="btn btn-outline-primary mb-2">Назад</a>
            <!-- Modern Comfortable Post Content Box with Image -->
            <div class="card border-0 shadow p-4">
                <h2 class="mb-3">{{$post->title}}</h2>

                <!-- Modern Comfortable Image Container -->
                <div class="image-container-1 mb-3">
                    <img src="{{ asset($post->img) }}" alt="Post Image" class="img-fluid rounded">
                </div>
                <!-- End Modern Comfortable Image Container -->
                <p class="mb-4">{{$post->content}}</p>
                <p class="text-muted">{{$post->created_at->format('F j, Y')}} by {{$post->user->name}}</p>
                <!-- Buttons for Edit and Delete -->
                @can('delete', $post)
                <div class="mb-3">
                    <a href="{{route('posts.edit', $post->id)}}" class="btn btn-outline-info">Edit</a>
                    <form action="{{route('posts.destroy', $post->id)}}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger" type="submit">Delete</button>
                    </form>
                </div>
                @endcan
                @auth
                <form action="{{route('posts.rate', $post->id)}}" method="post" class="mt-3">
                    @csrf
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rate this post:</label>
                        <select class="form-select" id="rating" name="rating">
                            @for($i=1; $i<=5; $i++) <option {{$myRating == $i ? 'selected' : ''}} value="{{$i}}">{{$i}}
                                </option>
                                @endfor
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Rating</button>
                </form>
                @endauth
                <!-- End Rating Form -->

                <!-- Average Rating Section -->
                <div class="mt-3">
                    <h3 class="mb-2">Average Rating</h3>
                    <p class="mb-0">{{$avgRating}}</p>
                </div>
                <!-- End Average Rating Section -->
            </div>
            <!-- End Modern Comfortable Post Content Box with Image -->

            <!-- Comment Section -->
            <div class="card border-0 shadow p-4 mt-4">
                <h3 class="mb-3">Comments</h3>
                <!-- Comment Form -->
                <form action="{{route('posts.comment', $post->id)}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="comment" class="form-label">Write a comment:</label>
                        <textarea class="form-control" id="comment" name="content" rows="3"></textarea>
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Comment</button>
                </form>
                @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <!-- End Comment Form -->

                <!-- Comments List with Modern Styling -->
                @foreach($comments as $comment)
                <div class="comments-list mt-3 border border-3 p-3">
                    <div class="comment d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <!-- Container for avatar and user info -->
                            <!-- Assuming $comment->user->avatar contains the URL of the user's avatar -->
                            <p class="mb-0 ms-2"><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}
                            </p>
                        </div>
                        @can('delete', $comment)
                        <form action="{{ route('posts.commentDel', $comment->id) }}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm" type="submit">Delete</button>
                        </form>
                        @endcan
                    </div>
                </div>

                @endforeach
                <!-- End Comments List with Modern Styling -->
            </div>
            <!-- End Comment Section -->
        </div>
    </div>
</div>

@endsection