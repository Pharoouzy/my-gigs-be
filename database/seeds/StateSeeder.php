<?php

use App\Models\State;
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
                'country_id' => 1,
                'name' => 'Lagos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        State::insert($states);
    }
}
