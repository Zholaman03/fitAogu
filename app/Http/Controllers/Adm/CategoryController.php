<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    public function index(Category $category){
        return view('adm.categories', ['categories'=>Category::all()]);
    }

    public function addCategory(Request $req){
       
        $validated = $req->validate([
            'name'=>'required|max:25|unique:categories',
            'code'=>'required|max:5|unique:categories'
        ]);

        Category::create($validated);
        return back()->with('message', 'Added!');
    }
}
