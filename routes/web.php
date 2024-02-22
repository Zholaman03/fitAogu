<?php

use App\Http\Controllers\Adm\AdminPostsController;
use App\Http\Controllers\Adm\CategoryController;
use App\Http\Controllers\Adm\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth2;
use App\Http\Controllers\Auth2\LoginController;
use App\Http\Controllers\Auth2\RegisterController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function(){
    return redirect()->route('posts.index');
});
Route::get('posts/mypost', function(){
    return redirect()->route('posts.index');
});

Route::middleware('hasrole:moderator')->group(function(){
    
});
Route::middleware('auth')->group(function(){
    Route::resource('posts', PostController::class)->only('create', 'edit', 'store', 'destroy', 'update');
    Route::get('posts/mypost/{user}', [PostController::class, 'index'])->name('posts.myPost');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/posts/{post}', [PostController::class, 'comment'])->name('posts.comment');
    Route::delete('/posts/delete/{comment}', [PostController::class, 'commentDel'])->name('posts.commentDel');
    ROute::post('/posts/{post}/rate', [PostController::class, 'rate'])->name('posts.rate');
    Route::middleware('hasrole:admin,moderator')->group(function(){
        Route::get('/adm/users', [UserController::class, 'index'])->name('adm.users.index');
        Route::get('/adm/users/{user}', [UserController::class, 'userPosts'])->name('adm.users.userPosts');
        Route::delete('/adm/users/deleteAllPosts', [UserController::class, 'deleteAll'])->name('adm.users.deleteAll');
        Route::get('/adm/users/showUserPosts/{post}', [UserController::class, 'showUserPosts'])->name('adm.users.showUserPosts');
        Route::delete('/adm/users/showUserPosts/{post}/showPost', [UserController::class, 'delete'])->name('adm.users.delete');
        Route::get('/adm/users/{user}/searchPost', [UserController::class, 'userPosts'])->name('adm.users.searchPost');
        Route::get('/adm/users/search', [UserController::class, 'index'])->name('adm.users.search');
        Route::get('/adm/users/{user}/edit', [UserController::class, 'edit'])->name('adm.users.edit');
        Route::put('/adm/users/{user}', [UserController::class, 'changeRole'])->name('adm.users.changeRole');
        Route::put('/adm/users/{user}/ban', [UserController::class, 'ban'])->name('adm.users.ban');
        Route::put('/adm/users/{user}/unban', [UserController::class, 'unban'])->name('adm.users.unban');
        //CategoryAdminPanel
        Route::get('/adm/category', [CategoryController::class, 'index'])->name('adm.categories.index');
        Route::post('/adm/category', [CategoryController::class, 'addCategory'])->name('adm.categories.add');
        //PostsAdminPanel
        Route::get('/adm/posts', [AdminPostsController::class, 'index'])->name('adm.posts.index');
        Route::get('/adm/posts/search', [AdminPostsController::class, 'index'])->name('adm.posts.search');

    });
});
Route::resource('posts', PostController::class)->only('index', 'show');
Route::get('/posts/category/{category}', [PostController::class, 'postsByCategory'])->name('posts.category');
// Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
// Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
// Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
// Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');




// Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/register', [RegisterController::class, 'create'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [LoginController::class, 'create'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');