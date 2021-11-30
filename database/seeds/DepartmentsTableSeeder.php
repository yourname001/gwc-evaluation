<?php

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::insert([
            ['name' => 'College of Education'],
            ['name' => 'College of Criminology'],
            ['name' => 'College of Information Technology Education'],
            ['name' => 'College of Information Business Administration'],
        ]);
    }
}
