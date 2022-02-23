<?php

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subject::insert([
            [
                'subject_code' => 'CC101',
                'title' => 'Introduction of Computing',
            ],
            [
                'subject_code' => 'CC102',
                'title' => 'Fundamentals of Programming (Java)',
            ],
            [
                'subject_code' => 'PSYCH 1',
                'title' => 'Understanding the Self',
            ],
            [
                'subject_code' => 'SOCSCI 1',
                'title' => 'Reading in the Philippine History',
            ],
            [
                'subject_code' => 'MATH 1',
                'title' => 'Mathematics in the Modern World',
            ],
            [
                'subject_code' => 'FIL 1',
                'title' => 'Kontekstwalisadong Komunikasyon sa Filipino',
            ],
            [
                'subject_code' => 'NSTP 1',
                'title' => 'Civic Welfare Training Service 1',
            ],
            [
                'subject_code' => 'PE 1',
                'title' => 'Movement Enhancement',
            ],
            [
                'subject_code' => 'DS101',
                'title' => 'Discrete Structured',
            ],
            [
                'subject_code' => 'CC103',
                'title' => 'Intermediate Programming (Adv. Java)',
            ],
            [
                'subject_code' => 'ENGL 1',
                'title' => 'Purposive Communication',
            ],
            [
                'subject_code' => 'SCi 1',
                'title' => 'Science, Technology and Society',
            ],
            [
                'subject_code' => 'PHILO 1',
                'title' => 'Ethics',
            ],
            [
                'subject_code' => 'FIL 2',
                'title' => "Filipino sa iba't ibang disiplina",
            ],
            [
                'subject_code' => 'NSTP 2',
                'title' => 'Civic Welfare Training Service 2',
            ],
            [
                'subject_code' => 'PE 2',
                'title' => 'Fitness Exercise',
            ],
            [
                'subject_code' => 'CC104',
                'title' => 'Data Structures & Algorithms',
            ],
            [
                'subject_code' => 'OOP101',
                'title' => 'Object Oriented Programming',
            ],
            [
                'subject_code' => 'SP101',
                'title' => 'Social and Professional Issues',
            ],
            [
                'subject_code' => 'HC1101',
                'title' => 'Introduction to Human Computer Interaction 1',
            ],
            [
                'subject_code' => 'IM101',
                'title' => 'Fundamentals of Database Systems',
            ],
            [
                'subject_code' => 'GV101',
                'title' => 'Intro to Graphics Design',
            ],
            [
                'subject_code' => 'HUM 1',
                'title' => 'Art Appreciation',
            ],
            [
                'subject_code' => 'PE 3',
                'title' => 'Physical Activity Towards Health and Fitnes',
            ],
            [
                'subject_code' => 'CC105',
                'title' => 'Information Magement 1',
            ],
            [
                'subject_code' => 'NET101',
                'title' => 'Networking 1',
            ],
            [
                'subject_code' => 'IPT101',
                'title' => 'Integrative Programming and Technologies 1',
            ],
            [
                'subject_code' => 'MS102',
                'title' => 'Quantitative Methods (incl. modeling & Simulation)',
            ],
            [
                'subject_code' => 'LIT 1',
                'title' => 'Sosyedad at Literatura/Panitikang Panlipunan',
            ],
            [
                'subject_code' => 'PT101',
                'title' => 'Platform-based Development (Web Systems)',
            ],
            [
                'subject_code' => 'SAD311',
                'title' => 'System Analysis and Design',
            ],
            [
                'subject_code' => 'IM102',
                'title' => 'Advance Database Systems',
            ],
            [
                'subject_code' => 'NET102',
                'title' => 'Networking 2',
            ],
            [
                'subject_code' => 'SIA 101',
                'title' => 'System Integration and Architecture',
            ],
            [
                'subject_code' => 'AS101',
                'title' => 'Information Assurance and Security 1',
            ],
            [
                'subject_code' => 'CC106',
                'title' => "Application Dev't and Emerging Technologies",
            ],
            [
                'subject_code' => 'ITELEC1',
                'title' => "IT Major Elective 1 (Graphics & Visual Computing)"
            ],
            [
                'subject_code' => "RIZAL1RIZAL1",
                'title' => "Rizal's Life and Works"
            ],
            [
                'subject_code' => "IT312",
                'title' => "Computer Accounting (with SAP)"
            ],
            [
                'subject_code' => "PT102 PT103",
                'title' => "Platform-based Dev't (Multimedia Systems) Platform-based Development (Android Programming)"
            ],
            [
                'subject_code' => "CAPS101",
                'title' => "Capstone Project and Research 1"
            ],
            [
                'subject_code' => "LIT2",
                'title' => "Sine Sosyedad/ Pelikulang Panlipunan"
            ],
            [
                'subject_code' => "SE101",
                'title' => "Software Engineering 1"
            ],
            [
                'subject_code' => "ITELEC2",
                'title' => "IT Major Elective 2 (Data warehousing)"
            ],
            [
                'subject_code' => "CAPS102",
                'title' => "Capstone Project and Research 2"
            ],
            [
                'subject_code' => "SA101",
                'title' => "System Administration and Maintenance 1"
            ],
            [
                'subject_code' => "ITELEC3",
                'title' => "IT Major Elective 3 (Management Information Systems)"
            ],
            [
                'subject_code' => "OS101",
                'title' => "Operating Systems"
            ],
            [
                'subject_code' => "ITELEC4",
                'title' => "IT Major Elective 4 (Web Systems & Development"
            ],
            [
                'subject_code' => "PRAC101",
                'title' => "OJT Practicum (486 hours)"
            ]
        ]);
    }
}
