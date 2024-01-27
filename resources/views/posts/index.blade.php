@extends('layouts.app')

@section('title', 'INDEX PAGE')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @can('create', App\Models\Post::class)
        <div><a href="{{route('posts.create')}}" class="btn btn-primary">GO TO CREATE</a></div>
        @endcan
        <div class="col-md-10">
        @foreach($posts as $post)
                <div class="forPhone card mt-3 border border-primary">
                    <div class="card-body">
                        <h5 class="card-title">{{$post->title}}</h5>
                        <p class="card-text">{{$post->content}}</p>
                        <p><small>author: {{$post->user->name}}</small></p>
                        <a href="{{route('posts.show', $post->id)}}" class="card-link">Подробнее</a>

                    </div>
                </div>
                @endforeach
        </div>
    </div>
</div>
@endsection
       
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>