<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserTableSeeder::class);
         $this->call(ProductTableSeeder::class);
         $this->call(RoleTableSeeder::class);
         $this->call(RoleUserTableSeeder::class);
         $this->call(CategoryTableSeeder::class);
         $this->call(PermissionsTableSeeder::class);
         $this->call(PermissionRoleTableSeeder::class);
    }
}
