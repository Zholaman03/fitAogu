@extends('layouts.app')

@section('title', 'INDEX PAGE')

@section('searchForm')
<form class="d-flex" action="{{route('posts.index')}}" role="search">
    <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-primary" type="submit">Искать</button>
</form>
@endsection
@section('content')
<div class="container ">
    <div class="row justify-content-center">
        <div class="container w-75">
           
            <div class="row justify-content-center ">
                @foreach($posts as $post)
                <div class="col-lg-8 ">
                    <!-- Post Content Box -->
                    <div class="post-box bg-white ">
                        <h2><a href="{{route('posts.show', $post->id)}}" class="card-link">{{$post->title}}</a></h2>

                        <div class="image-container">
                            <img src="{{ asset($post->img) }}" class="img-fluid" alt="Post Image">
                        </div>
                        <p>Posted on {{$post->created_at->format('F j, Y')}} by {{$post->user->name}}</p>
                    </div>
                    <!-- End Post Content Box -->

                    <!-- You can add more post boxes if needed -->
                </div>
                @endforeach

            </div>

        </div>

    </div>
</div>

{{ $posts->links() }}


@endsection