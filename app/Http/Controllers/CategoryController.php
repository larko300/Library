<?php

namespace App\Http\Controllers;

use App\Book;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function show($id)
    {
        $category = Category::find($id);
        $books = $category->books()->paginate(9);
        $categories = Category::all();
        return view('book', compact('books', 'categories'));
    }
}
