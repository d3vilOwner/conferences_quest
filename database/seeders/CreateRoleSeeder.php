<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class CreateRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Роль Админа и его разрешения
        $adminRole = Role::create([
            'name' => 'admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $adminPermissions = Permission::get();
        $adminRole->syncPermissions($adminPermissions);

        //Роль Слушатель и его разрешения
        $listenerRole = Role::create([
            'name' => 'listener',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $listenerPermissions = [
            'show conferences details',
        ];
        $listenerRole->syncPermissions($listenerPermissions);

        // Роль участник и его разрешения
        $announcerRole = Role::create([
            'name' => 'announcer',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        
        $announcerPermissions = [
            'show conferences details',
            'edit conferences',
            'create conferences',
            'delete conferences',
            'create reports',
            'update reports',
            'delete reports'
        ]; 

        $announcerRole->syncPermissions($announcerPermissions);

    }
}
