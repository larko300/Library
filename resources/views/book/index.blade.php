@extends('layouts.app')

@section('content')
    <div class="justify-content-center">
        @include('navbar')
        <ul class="nav justify-content-end mt-5 ml-5">
            <li class="nav-item dropdown mr-1">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sort
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('book.index', ['sort' => 'name', 'option' => 'asc']) }}">Name</a>
                    <a class="dropdown-item" href="{{ route('book.index', ['sort' => 'author', 'option' => 'asc']) }}">Author</a>
                    <a class="dropdown-item" href="{{ route('book.index', ['sort' => 'id', 'option' => 'desc']) }}">Old first</a>
                </div>
            </li>
            <form class="nav-item form-inline my-2 my-lg-0" action="{{ route('book.search') }}">
                <input class="form-control mr-sm-2" type="search" value="{{ request()->get('query') }}" name="query" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </ul>
        <div class="row mt-5">
            <div class="col-2">
                <div class="list-group">
                    <h5 class="mb-1">Category:</h5>
                    @foreach($categories as $category)
                        <a href="{{ route('category.show', $category->id) }}" class="list-group-item list-group-item-action">{{ $category->name }}</a>
                    @endforeach
                </div>
            </div>
            <div class="col-10">
                @foreach($books->chunk(3) as $chunked_books)
                    <div class="row">
                        @foreach($chunked_books as $book)
                            <div class="card col-4" style="width: 18rem;">
                                <img class="card-img-top pt-3" src="{{ asset('image/'.$book->image) }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $book->name }}</h5>
                                    <h6 class="card-subtitle mb-2">Author: {{ $book->author }}</h6>
                                    <p class="card-text">{{ $book->description }}</p>
                                    <p class="card-text">
                                    @if($book->categories)
                                        <ul>
                                            @foreach($book->categories as $category)
                                                <li>
                                                    {{ $category->name }}
                                                </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                        </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-center pt-4">
            {{ $books->links() }}
        </div>
    </div>
@endsection
