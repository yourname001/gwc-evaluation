<?php

use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Section::insert([
            [
                'year_level' => 1,
                'name' => 'CITCS-1A'
            ],
            [
                'year_level' => 1,
                'name' => 'CITCS-1B'
            ],
            [
                'year_level' => 1,
                'name' => 'CITCS-1C'
            ],
            [
                'year_level' => 2,
                'name' => 'CITCS-2A'
            ],
            [
                'year_level' => 2,
                'name' => 'CITCS-2B'
            ],
            [
                'year_level' => 2,
                'name' => 'CITCS-2C'
            ],
            [
                'year_level' => 3,
                'name' => 'CITCS-3A'
            ],
            [
                'year_level' => 3,
                'name' => 'CITCS-3B'
            ],
            [
                'year_level' => 3,
                'name' => 'CITCS-3C'
            ]
        ]);
    }
}
