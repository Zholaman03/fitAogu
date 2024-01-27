<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shows</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <a href="{{route('posts.index')}}">GO back</a>
    <div class="container d-flex justify-content-center ">

        <div class="border border-dark rounded p-4">
            <div class="card" style="width: 18rem;">
                <img src="{{asset($post->img)}}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{$post->title}}</h5>
                    <p class="card-text">{{$post->content}}</p>
                </div>
            </div>
            <hr>
            <div class="w-100 d-flex justify-content-around">
                @can('delete', $post)
                <a href="{{route('posts.edit', $post->id)}}" class="btn btn-warning">Edit</a>

                <form action="{{route('posts.destroy', $post->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">DELETE</button>
                </form>
                @endcan
            </div>
            <div>
                @if($avgRating != 0)
                <h3>rating: {{$avgRating}}</h3>
                @endif
            </div>
            <div>
                @auth
                <form action="{{route('posts.rate', $post->id)}}" method="post">
                    @csrf
                    <select name="rating" id="">
                        @for($i=0; $i<=5; $i++) <option {{$myRating == $i ? 'selected' : ''}} value="{{$i}}">
                            {{ $i=0 ? 'Not Rated' : $i}}
                            </option>

                            @endfor
                    </select>
                    <button type="submit" class="btn btn-warning">Rate</button>
                </form>
                @endauth
            </div>
            <div>
                <h2>Comment</h2>
                <form action="{{route('posts.comment', $post->id)}}" method="post">
                    @csrf
                    <textarea name="content" class="w-100" placeholder="Comment" id="" cols="30" rows="10"></textarea>
                    <input type="hidden" name="post_id" value="{{$post->id}}">
                    <button type="submit" class="btn btn-success">Отправить</button>
                </form>
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
            <div class="border border-1 mt-3">
                @foreach($comments as $comment)

                <div class="border border-2 m-2 p-2 d-flex justify-content-between">
                    <div>
                        {{$comment->content}} <br>
                        <small><i>Data: {{$comment->created_at}} | author: {{$comment->user->name}}</i></small>
                    </div>

                    <div>
                        @can('delete', $comment)
                        <form action="{{route('posts.commentDel', $comment->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                        @endcan
                    </div>

                </div>

                @endforeach
            </div>
        </div>
    </div>
    <div class="container"></div>
</body>

</html>