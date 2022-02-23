<?php

use Illuminate\Database\Seeder;
use App\Models\Course;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::insert([
            [
                'department_id' => 3,
                'name' => 'Bachelor of Science in Information Technology'
            ],
            [
                'department_id' => 3,
                'name' => 'Bachelor of Science in Computer Science'
            ],
            [
                'department_id' => 2,
                'name' => 'Bachelor of Science in Criminology'
            ],
            [
                'department_id' => 1,
                'name' => 'Bachelor of Secondary Education Major in English'
            ],
            [
                'department_id' => 4,
                'name' => 'Bachelor of Science in Business Administration'
            ],
            [
                'department_id' => 1,
                'name' => 'Bachelor of Technical-Vocational Teacher Education (Major in Automotive Technology)'
            ],
            [
                'department_id' => 1,
                'name' => 'Bachelor of Technical-Vocational Teacher Education (Major in Electrical Technology)'
            ],
            [
                'department_id' => 1,
                'name' => 'Bachelor of Technical-Vocational Teacher Education (Major in Electronics Technology)'
            ],
        ]);
    }
}
