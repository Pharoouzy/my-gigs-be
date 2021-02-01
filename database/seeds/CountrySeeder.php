<?php

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            [
                'code' => 'NG',
                'name' => 'Nigeria',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        Country::insert($countries);
    }
}
