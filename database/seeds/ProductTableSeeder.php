<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->delete();

        DB::table('products')->insert([
            'title' => 'Product 1',
            'price' => '100.00',
            'sku' => '1',
            'image' => '1.jpg',
            'description' => 'description 1',
            'quantity' => 1,
            'category_id' => 1
        ]);
        DB::table('products')->insert([
            'title' => 'Product 2',
            'price' => '200.00',
            'sku' => '2',
            'image' => '2.png',
            'description' => 'description 2',
            'quantity' => 2,
            'category_id' => 2
        ]);
        DB::table('products')->insert([
            'title' => 'Product 3',
            'price' => '300.00',
            'sku' => '3',
            'image' => '3.png',
            'description' => 'description 3',
            'quantity' => 0,
            'category_id' => 3
        ]);
    }
}
