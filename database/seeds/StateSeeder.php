<?php

use App\Models\State;
use App\Models\Country;
use Illuminate\Database\Seeder;

/**
 * Class StateSeeder
 */
class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = [
            [
                "name" => "Abia",
            ],
            [
                "name" => "Adamawa",
            ],
            [
                "name" => "Akwa Ibom",
            ],
            [
                "name" => "Anambra",
            ],
            [
                "name" => "Bauchi",
            ],
            [
                "name" => "Bayelsa",
            ],
            [
                "name" => "Benue",
            ],
            [
                "name" => "Borno",
            ],
            [
                "name" => "Cross River",
            ],
            [
                "name" => "Delta",
            ],
            [
                "name" => "Ebonyi",
            ],
            [
                "name" => "Edo",
            ],
            [
                "name" => "Ekiti",
            ],
            [
                "name" => "Enugu",
            ],
            [
                "name" => "FCT",
            ],
            [
                "name" => "Gombe",
            ],
            [
                "name" => "Imo",
            ],
            [
                "name" => "Jigawa",
            ],
            [
                "name" => "Kaduna",
            ],
            [
                "name" => "Kano",
            ],
            [
                "name" => "Katsina",
            ],
            [
                "name" => "Kebbi",
            ],
            [
                "name" => "Kogi",
            ],
            [
                "name" => "Kwara",
            ],
            [
                "name" => "Lagos",
            ],
            [
                "name" => "Nasarawa",
            ],
            [
                "name" => "Niger",
            ],
            [
                "name" => "Ogun",
            ],
            [
                "name" => "Ondo",
            ],
            [
                "name" => "Osun",
            ],
            [
                "name" => "Oyo",
            ],
            [
                "name" => "Plateau",
            ],
            [
                "name" => "Rivers",
            ],
            [
                "name" => "Sokoto",
            ],
            [
                "name" => "Taraba",
            ],
            [
                "name" => "Yobe",
            ],
            [
                "name" => "Zamfara",
            ],
        ];
        $country = Country::where('code', 'NG')->first();

        foreach ($states as $state){
            State::create([
                'country_id' => $country->id,
                'name' => $state['name']
            ]);
        }
    }
}
