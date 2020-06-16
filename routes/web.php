<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/book', 'BookController@index')->name('book.index');

Route::get('/book/search', 'BookController@search')->name('book.search');

Route::get('/category/{category}', 'CategoryController@show')->name('category.show');

Route::resource('user', 'UserController', [
    'except' => [ 'show', 'delete' ]
]);

Auth::routes(['verify' => true]);
