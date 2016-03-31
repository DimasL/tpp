<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->delete();

        DB::table('permissions')->insert([
            'title' => 'Create',
            'slug' => 'create'
        ]);
        DB::table('permissions')->insert([
            'title' => 'Update',
            'slug' => 'update'
        ]);
        DB::table('permissions')->insert([
            'title' => 'Read',
            'slug' => 'read'
        ]);
        DB::table('permissions')->insert([
            'title' => 'Delete',
            'slug' => 'delete'
        ]);
    }
}
