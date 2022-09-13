<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CreateCountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::create([
            'name' => 'Ukraine',
        ]);

        Country::create([
            'name' => 'USA',
        ]);

        Country::create([
            'name' => 'Spain',
        ]);

        Country::create([
            'name' => 'Canada',
        ]);

        Country::create([
            'name' => 'France',
        ]);

        Country::create([
            'name' => 'Greece',
        ]);

        Country::create([
            'name' => 'Poland',
        ]);
    }
}
