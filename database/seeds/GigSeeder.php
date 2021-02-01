<?php

use App\Models\Gig;
use Illuminate\Database\Seeder;

/**
 * Class GigSeeder
 */
class GigSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gigs = [
            [
                'id' => $this->generateId(),
                'role' => 'FullStack Developer',
                'company_name' => 'Krystal',
                'country_id' => 1,
                'state_id' => 1,
                'address' => 'Lekki, Lagos',
                'min_salary' => 250000,
                'max_salary' => 500000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        Gig::insert($gigs);
    }

    /**
     * @return bool|string
     */
    public function generateId(){
        $id = substr(md5(substr(hexdec(uniqid()), -6)), -24);

        if(Gig::where('id', $id)->exists()){
            return $this->generateId();
        }

        return $id;
    }
}
