<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conference;
use Carbon\Carbon;

class CreateConferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Conference::create([
            'title' => 'Conference 1',
            'conference_date' => '2022-07-07',
            'latitude' => '20',
            'longitude' => '45',
            'country_id' => '3',
            'user_id' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Conference::create([
            'title' => 'Conference 2',
            'conference_date' => '2022-07-07',
            'latitude' => '20',
            'longitude' => '45',
            'country_id' => '2',
            'user_id' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Conference::create([
            'title' => 'Conference 3',
            'conference_date' => '2022-07-07',
            'latitude' => '20',
            'longitude' => '45',
            'country_id' => '2',
            'user_id' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Conference::create([
            'title' => 'Conference 4',
            'conference_date' => '2022-07-07',
            'latitude' => '20',
            'longitude' => '45',
            'country_id' => '1',
            'user_id' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Conference::create([
            'title' => 'Conference 5',
            'conference_date' => '2022-07-07',
            'latitude' => '20',
            'longitude' => '45',
            'country_id' => '6',
            'user_id' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Conference::create([
            'title' => 'Conference 6',
            'conference_date' => '2022-07-07',
            'latitude' => '20',
            'longitude' => '45',
            'country_id' => '2',
            'user_id' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Conference::create([
            'title' => 'Conference 7',
            'conference_date' => '2022-07-07',
            'latitude' => '20',
            'longitude' => '45',
            'country_id' => '7',
            'user_id' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Conference::create([
            'title' => 'Conference 8',
            'conference_date' => '2022-07-07',
            'latitude' => '20',
            'longitude' => '45',
            'country_id' => '3',
            'user_id' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Conference::create([
            'title' => 'Conference 9',
            'conference_date' => '2022-07-07',
            'latitude' => '20',
            'longitude' => '45',
            'country_id' => '4',
            'user_id' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Conference::create([
            'title' => 'Conference 10',
            'conference_date' => '2022-07-07',
            'latitude' => '20',
            'longitude' => '45',
            'country_id' => '1',
            'user_id' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
