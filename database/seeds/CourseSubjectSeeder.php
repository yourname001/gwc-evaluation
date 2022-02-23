<?php

use Illuminate\Database\Seeder;
use App\Models\CourseSubject;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class CourseSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::unprepared(file_get_contents(database_path('seeds/sql/course_subjects.txt')));
    }
}
