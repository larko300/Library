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
        $booksId = factory(App\Book::class, 10)->create()->pluck('id')->toArray();
        $category = Category::find(2);
        $category->books()->attach($booksId);
    }
}
