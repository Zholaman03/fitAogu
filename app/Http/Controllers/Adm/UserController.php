<?php

namespace App\Http\Controllers\adm;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
class UserController extends Controller
{
    //
    public function index(Request $req){
        $users = null;
        if($req->search){
            $users = User::where('name', 'LIKE', '%'.$req->search.'%')->orWhere('email', 'LIKE', '%'.$req->search.'%')->with('role')->get();
        }
        else{
            $users = User::with('role')->get();
        }
       
        return view('adm.users', ['users'=>$users]);
    }

    public function userPosts(User $user, Request $req){
        $posts = null;
        if($req->search){
            $posts = Post::where('title', 'LIKE', '%'.$req->search.'%')->get();
        }
        else{
            $posts = $user->posts;
        }
        
        return view('adm.posts', ['posts'=>$posts, 'user'=>$user]);
    }

    public function showUserPosts(Post $post){
      
        return view('adm.showPost', ['post'=>$post]);
    }

    public function ban(User $user){
        $user->update([
            'is_active' => false
        ]);

        return back();
    }

    public function unban(User $user){
        $user->update([
            'is_active' => true
        ]);

        return back();
    }

    public function changeRole(User $user, Request $req){

        $user->update([
            'role_id' => $req->input('role')
        ]);
        return back();
    }

    public function delete(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('adm.users.userPosts', $post->user_id);
        
    }

    
}
