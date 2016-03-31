<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
            'name' => 'DimasL',
            'email' => 'lakakalaka@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password')
        ]);
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'dmytro.s.liakin@w3.co',
            'password' => \Illuminate\Support\Facades\Hash::make('password')
        ]);
        DB::table('users')->insert([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password')
        ]);
    }
}
