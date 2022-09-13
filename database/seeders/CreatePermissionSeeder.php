<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CreatePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'show conferences details']);
        Permission::create(['name' => 'edit conferences']);
        Permission::create(['name' => 'create conferences']);
        Permission::create(['name' => 'delete conferences']);

        Permission::create(['name' => 'create reports']);
        Permission::create(['name' => 'update reports']);
        Permission::create(['name' => 'delete reports']);

        Permission::create(['name' => 'create categories']);
        Permission::create(['name' => 'update categories']);
        Permission::create(['name' => 'delete categories']);

        Permission::create(['name' => 'create subcategories']);
        Permission::create(['name' => 'update subcategories']);
        Permission::create(['name' => 'delete subcategories']);
    }
}
