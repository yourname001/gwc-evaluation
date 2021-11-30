<?php

use Illuminate\Database\Seeder;
use App\Models\Faculty;

class FacultiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Faculty::insert([
            [
                'faculty_id',
                'first_name',
                'middle_name',
                'last_name',
                'gender',
                'contact_number',
                'address'
            ],  
        ]);
    }
}
