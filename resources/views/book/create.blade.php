@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="p-2"><h5 class="card-title">Create book:</h5></div>
                            <div class="ml-auto p-2"><a href="{{ route('book.index') }}"><button type="submit" class="btn btn-secondary">Back</button></a></div>
                        </div>
                        <form method="POST" action="{{ route('book.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="author" class="col-md-4 col-form-label text-md-right">Author</label>
                                <div class="col-md-6">
                                    <input id="author" type="text" class="form-control" name="author" value="{{ old('author') }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>
                                <div class="col-md-6">
                                    <textarea type="text" name="description" class="form-control" id="description" rows="3" required>{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right" for="category">Category</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="category" id="category">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id  }}" {{ old('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label text-md-right">Image</label>
                                <div class="input-group col-md-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="image">Upload</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image"
                                               aria-describedby="inputGroupFileAddon01" name="image">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Create
                                    </button>
                                </div>
                            </div>
                        </form>
                        @include('errors')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
