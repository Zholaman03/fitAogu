<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class PostController extends Controller
{

    public function postsByCategory(Category $category){
        $posts = Post::where('category_id', $category->id)->paginate(5);
        return view('posts.index', ['posts'=>$posts, 'categories'=>Category::all()]);
    }

    public function index(Request $req,  User $user){
        $posts = null;
        $categories = Category::all();
        
        if($req->search){
            $posts = Post::where('title', 'LIKE', '%'.$req->search.'%')->get();
        }

        else{
            if($user->id){
            $posts = Post::where('user_id', $user->id)->paginate(5);
            }
            else{
                $posts = Post::paginate(5); 
            }
                 
        }
        
        return view('posts.index', compact('posts', 'categories'));
    }
    public function create(){
        $this->authorize('create', Post::class);
        return view('posts.create', ['categories'=>Category::all()]);
    }

    public function store(Request $req){
        $this->authorize('create', Post::class);
        $validated = $req->validate([
            'title'=>'required|max:255',
            'content'=>'required',
            'category_id'=>'required|numeric|exists:categories,id',
            'img'=>[
                'required',
                'image',
                'mimes:jpg,png,jpeg,gif,svg',
                'max:5120'
            ],
        ]);

        $fileName = time().$req->file('img')->getClientOriginalName();

        $image_path = $req->file('img')->storeAs('posts', $fileName, 'public');

        $validated['img'] = '/storage/'.$image_path; 
     
        Auth::user()->posts()->create($validated);
        // Post::create($validated+['user_id'=>Auth::user()->id]);
        return redirect()->route('posts.index');
    }

    public function comment(Request $req, Post $post){
       
        $validated = $req->validate([
            'content'=>'required',
            'post_id'=>'required|numeric|exists:posts,id'
        ]);
        // Auth::user()->comments()->create($validated);
        Comment::create($validated+['user_id'=>Auth::user()->id]);
        return back()->with('message', 'comment created');    
    }

    public function show(Post $post, Comment $comment){
        $post->load('comments.user');
        $myRate = 0;
        if(Auth::check()){
            $postRated = Auth::user()->postRated()->where('post_id', $post->id)->first();
            if($postRated != null){
                $myRate = $postRated->pivot->rating;
            }
        }
        

        $avgRating = 0;
        $sum = 0;
        $ratedUsers = $post->usersRated()->get();
        foreach($ratedUsers as $rateUser){
            $sum+=$rateUser->pivot->rating;
        }
        if(count($ratedUsers)>0){
            $avgRating = $sum/count($ratedUsers);
        }
        
        return view('posts.show', ['post'=>$post, 'comments'=>$post->comments, 'myRating'=>$myRate, 'avgRating'=>$avgRating]);
    }

    
    public function edit(Post $post)
    {
        return view('posts.edit', ['post'=>$post, 'categories'=>Category::all()]);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title'=>'required|max:255',
            'content'=>'required',
            'category_id'=>'required|numeric|exists:categories,id',
            'img'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:5120'
        ]);
        if ($request->hasFile('img')) {
            $oldImagePath = $post->img; // Получаем путь к старому изображению
            $fileName = time() . $request->file('img')->getClientOriginalName();
            $newImagePath = $request->file('img')->storeAs('posts', $fileName, 'public');
            $validated['img'] = '/storage/' . $newImagePath;
    
            // Удаляем старое изображение
            if ($oldImagePath && Storage::exists($oldImagePath)) {
                Storage::delete($oldImagePath);
            }
        } 
        $post->update($validated);
        return redirect()->route('posts.index');
    }
    

    public function destroy(Post $post)
    {

        $this->authorize('delete', $post);
        
        $post->delete();
        
        return redirect()->route('posts.index');
    }

    public function commentDel(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return back();
        // return redirect()->route('posts.show', $comment->post_id);
    }

    public function rate(Request $req, Post $post){
        $req->validate([
            'rating'=>'required|min:1|max:5'
        ]);
        $postRated = Auth::user()->postRated()->where('post_id', $post->id)->first();

        if($postRated != null){
            Auth::user()->postRated()->updateExistingPivot($post->id, ['rating'=>$req->input('rating')]);
        }
        else{
            Auth::user()->postRated()->attach($post->id, ['rating'=>$req->input('rating')]);
        }
        
        return back();
    }
}