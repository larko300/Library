<?php

namespace App\Http\Controllers;

use App\Book;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function index(Request $request)
    {
        if (request()->exists('sort')) {
            $validated = $request->validate([
                'sort' => Rule::in(['name', 'author', 'id']),
                'option' => Rule::in(['desc', 'asc'])
            ]);
            $books = Book::orderBy($validated['sort'], $validated['option'])->paginate(9);
            $books->appends(['sort' => $validated['sort'], 'option' => $validated['option']])->links();
        } else {
            $books = Book::paginate(9);
        }
        $categories = Category::all();
        return view('book', compact('books', 'categories'));
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'query' => 'required|string',
        ]);
        $books = Book::search($validated['query'])->paginate(9);
        $books->appends(['query' => $validated['query']])->links();
        $categories = Category::all();
        return view('book', compact('books', 'categories'));
    }
}
