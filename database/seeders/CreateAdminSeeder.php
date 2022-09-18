<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'firstname' => 'admin',
            'lastname' => 'admin',
            'role' => 'admin',
            'birthdate' => '2001-01-28',
            'country_id' => '2',
            'phone' => '0990846456',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $admin->assignRole('admin');
    }
}
