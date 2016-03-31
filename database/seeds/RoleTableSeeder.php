<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        DB::table('roles')->insert([
            'title' => 'Admin',
            'slug' => 'admin'
        ]);
        DB::table('roles')->insert([
            'title' => 'User',
            'slug' => 'user'
        ]);
        DB::table('roles')->insert([
            'title' => 'Banned',
            'slug' => 'banned'
        ]);
    }
}
