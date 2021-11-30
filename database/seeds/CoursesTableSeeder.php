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
            // 1st year 1st Sem 
            [
                'course_code' => 'CC101',
                'title' => 'Introduction of Computing',
            ],
            [
                'course_code' => 'CC102',
                'title' => 'Fundamentals of Programming (Java)',
            ],
            [
                'course_code' => 'PSYCH 1',
                'title' => 'Understanding the Self',
            ],
            [
                'course_code' => 'SOCSCI 1',
                'title' => 'Reading in the Philippine History',
            ],
            [
                'course_code' => 'MATH 1',
                'title' => 'Mathematics in the Modern World',
            ],
            [
                'course_code' => 'FIL 1',
                'title' => 'Kontekstwalisadong Komunikasyon sa Filipino',
            ],
            [
                'course_code' => 'NSTP 1',
                'title' => 'Civic Welfare Training Service 1',
            ],
            [
                'course_code' => 'PE 1',
                'title' => 'Movement Enhancement',
            ],
            // 1st Year 2nd Sem
            [
                'course_code' => 'DS101',
                'title' => 'Discrete Structured',
            ],
            [
                'course_code' => 'CC103',
                'title' => 'Intermediate Programming (Adv. Java)',
            ],
            [
                'course_code' => 'ENGL 1',
                'title' => 'Purposive Communication',
            ],
            [
                'course_code' => 'SCi 1',
                'title' => 'Science, Technology and Society',
            ],
            [
                'course_code' => 'PHILO 1',
                'title' => 'Ethics',
            ],
            [
                'course_code' => 'FIL 2',
                'title' => "Filipino sa iba't ibang disiplina",
            ],
            [
                'course_code' => 'NSTP 2',
                'title' => 'Civic Welfare Training Service 2',
            ],
            [
                'course_code' => 'PE 2',
                'title' => 'Fitness Exercise',
            ],
        ]);
    }
}
