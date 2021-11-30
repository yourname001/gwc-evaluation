<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserFaculty;
use App\Models\Faculty;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $system_admin_faculty = Faculty::create([
            'faculty_id' => 1234567001,
            'department_id' => 3,
			'first_name' => "Kyouma",
			'middle_name' => "Asd",
			'last_name' => "hououin",
			'gender' => "Male",
			'contact_number' => "09123456001",
        ]);

        $admin_faculty = Faculty::create([
            'faculty_id' => 1234567890,
            'department_id' => 3,
			'first_name' => "John Michael",
			'middle_name' => "D",
			'last_name' => "Fernandez",
			'gender' => "Male",
			'contact_number' => "09123456789",
        ]);

        $system_admin_user = User::create([
            'is_verified' => 1,
            'username' => 'master',
            'email' => 'hououinkyouma.000001@gmail.com',
            'password' => bcrypt('admin')
        ]);

        $admin_user = User::create([
            'is_verified' => 1,
            'username' => 'admin',
            'email' => 'jm.fernandez00@gmail.com',
            'password' => bcrypt('admin')
        ]);

        $system_admin_user->assignRole(1);
        $admin_user->assignRole(2);

        UserFaculty::create([
            'faculty_id' => $system_admin_faculty->id,
            'user_id' => $system_admin_user->id
        ]);

        UserFaculty::create([
            'faculty_id' => $admin_faculty->id,
            'user_id' => $admin_user->id
        ]);

    }
}
