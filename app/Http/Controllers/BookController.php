<?php

namespace App\Http\Controllers;

use App\Book;
use App\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

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
        return view('book/index', compact('books', 'categories'));
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'query' => 'required|string',
        ]);
        $books = Book::search($validated['query'])->paginate(9);
        $books->appends(['query' => $validated['query']])->links();
        $categories = Category::all();
        return view('book/index', compact('books', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $categories = Category::all();
        return view('book/create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string||min:3',
            'author' => 'required|string|min:3',
            'description' => 'required|string|min:3',
            'category' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);
        $book = new Book();
        $book->name = $request['name'];
        $book->author = $request['author'];
        $book->description = $request['description'];
        request()->has('image') ? $book->image = Storage::url(request()->file('image')->store('public')) : '';
        $book->save();
        $category = Category::find($request['category']);
        $category->books()->save($book);
        return redirect()->route('book.index')->with(['success' => 'Book created!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $categories = Category::all();
        $book = Book::find($id);
        return view('book/edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string||min:3',
            'author' => 'required|string|min:3',
            'description' => 'required|string|min:3',
            'category' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);
        $book = Book::find($id);
        $book->name = $request['name'];
        $book->author = $request['author'];
        $book->description = $request['description'];
        request()->has('image') ? Storage::delete($book->image) : '';
        $category = Category::find($request['category']);
        $book->category_id = $category->id;
        $book->save();
        return redirect('/book')->with(['success' => 'Book edited']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        $book->delete();
        return redirect('book')->with(['success' => 'Book deleted']);
    }
}
