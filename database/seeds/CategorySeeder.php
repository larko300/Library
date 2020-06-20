<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Arts & Music', 'Comics', 'Computers & Tech', 'Gay & Lesbian', 'Horror'];
        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category
            ]);
        }
    }
}
