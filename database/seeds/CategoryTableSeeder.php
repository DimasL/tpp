<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->delete();

        DB::table('categories')->insert([
            'title' => 'Category 1',
            'image' => '1.png',
            'description' => 'category description 1',
            'parent_category_id' => ''
        ]);
        DB::table('categories')->insert([
            'title' => 'Category 2',
            'image' => '2.png',
            'description' => 'category description 2',
            'parent_category_id' => ''
        ]);
        DB::table('categories')->insert([
            'title' => 'Category 3',
            'image' => '3.png',
            'description' => 'category description 3',
            'parent_category_id' => ''
        ]);

        DB::table('categories')->insert([
            'title' => 'Category 1.1',
            'image' => '1.png',
            'description' => 'category description 1.1',
            'parent_category_id' => 1
        ]);
        DB::table('categories')->insert([
            'title' => 'Category 2.1',
            'image' => '2.png',
            'description' => 'category description 2.1',
            'parent_category_id' => 2
        ]);
        DB::table('categories')->insert([
            'title' => 'Category 3.1',
            'image' => '3.png',
            'description' => 'category description 3.1',
            'parent_category_id' => 3
        ]);
    }
}
