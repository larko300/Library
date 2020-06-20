<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Category;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $books = factory(App\Book::class, 5)->create();
        $category = Category::find(5);
        $category->books()->saveMany($books);
    }
}
