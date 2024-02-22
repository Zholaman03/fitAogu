<?php

namespace App\Http\Controllers\Adm;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
class AdminPostsController extends Controller
{
    public function index(Request $req){
        $posts = null;
        if($req->search){
            $posts = Post::where('title', 'LIKE', '%'.$req->search.'%')->paginate(5);
        }
        else{
            $posts = Post::paginate(5);
        }

        
        return view('adm.posts', ['posts' => $posts]);
    }

}
