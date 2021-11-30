<?php

use Illuminate\Database\Seeder;
use App\Models\Group;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::insert([
            [
                'name' => 'PERSONALITY',
                'percentage' => '20',
                'priority' => '1',
                'group_for' => 'Faculty',
                'is_active' => '1'
            ],
            [
                'name' => 'MASTERY OF SUBJECT MATTER',
                'percentage' => '30',
                'priority' => '2',
                'group_for' => 'Faculty',
                'is_active' => '1'
            ],
            [
                'name' => 'METHODOLOGY',
                'percentage' => '30',
                'priority' => '3',
                'group_for' => 'Faculty',
                'is_active' => '1'
            ],
            [
                'name' => 'CLASSROOM MANAGEMENT',
                'percentage' => '20',
                'priority' => '4',
                'group_for' => 'Faculty',
                'is_active' => '1'
            ],
            [
                'name' => 'ADMINISTRATION',
                'percentage' => '30',
                'priority' => '1',
                'group_for' => 'Dean',
                'is_active' => '1'
            ],
            [
                'name' => 'FACULTY DEVELOPMENT',
                'percentage' => '35',
                'priority' => '2',
                'group_for' => 'Dean',
                'is_active' => '1'
            ],
            [
                'name' => 'STUDENT DEVELOPMENT',
                'percentage' => '35',
                'priority' => '3',
                'group_for' => 'Dean',
                'is_active' => '1'
            ],
        ]);
    }
}
