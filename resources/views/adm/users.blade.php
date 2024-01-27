@extends('layouts.adm')

@section('title', 'Users Page')

@section('content')
<h1>Users Page</h1>
<form action="{{route('adm.users.search')}}" method="get">

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">@</span>
        </div>
        <input type="text" name="search" class="form-control" placeholder="Search" aria-label="Username"
            aria-describedby="basic-addon1">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>

</form>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">E-mail</th>
            <th scope="col">Role_name</th>
            <th scope="col">#</th>
            <th scope="col">#</th>

        </tr>
    </thead>
    <tbody>
        @for($i = 0; $i<count($users); $i++) <tr>
            <td scope="row">{{$i+1}}</td>
            <td><a href="{{route('adm.users.userPosts', $users[$i]->id)}}">{{$users[$i]->name}}</a></td>
            <td>{{$users[$i]->email}}</td>
            <td>{{$users[$i]->role->name}}</td>
            <td>
                <form action="
                        @if($users[$i]->is_active)
                        {{route('adm.users.ban', $users[$i]->id)}}
                        @else
                        {{route('adm.users.unban', $users[$i]->id)}}
                        @endif" method="POST">
                    @csrf
                    @method('PUT')
                    <button class="
                    @if($users[$i]->is_active)
                    btn btn-danger
                    @else
                    btn btn-success
                    @endif
                    " type="submit">
                        @if($users[$i]->is_active)
                        Ban
                        @else
                        Unban
                        @endif
                    </button>
                </form>

            </td>
            <td>
            @if($users[$i]->role->name != 'admin')
            <form action="
                        
                        {{route('adm.users.changeRole', $users[$i]->id)}}
                       
                      
                        " method="POST">
                    @csrf
                    @method('PUT')
                    
                    <select name="role" id="">
                        <option 
                        @if($users[$i]->role->name == 'user')
                        selected
                        @endif
                        value="1"
                        >User</option>
                        <option 
                        @if($users[$i]->role->name == 'moderator')
                        selected
                        @endif
                        value="2"
                        >Moderator</option>
                    </select>
                    
                    <button class=" btn btn-warning
                    " type="submit">
                        Save
                    </button>
                </form>
            </td>
            @endif
            </tr>
            @endfor
    </tbody>
</table>
@endsection