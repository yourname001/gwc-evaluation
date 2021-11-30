<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('registration_complete', 'StudentRegistrationController@registrationComplete')->name('registration_complete');

Route::get('/home', function(){
	return redirect()->route('evaluations.index');
})->name('home');

Route::post('student_register', [
	'as' => 'student_registration.register',
	'uses' => 'StudentRegistrationController@register'
]);

Route::group(array('middleware'=>['auth']), function() {

    /**
	 * Roles and Permissions
	 */
    Route::resource('roles', 'Configuration\RolePermission\RoleController');
	// Route::get('/roles_get_data', 'Configuration\RolePermission\RoleController@get_data')->name('roles.get_data');
	// restore
	Route::post('roles/restore/{role}', [
		'as' => 'roles.restore',
		'uses' => 'Configuration\RolePermission\RoleController@restore'
	]);
	
	/**
	 * Users
	 */
	Route::resource('users', 'UserController');
	// User Account settings
	Route::get('account/{user}', [
		'as' => 'users.account_settings',
		'uses' => 'UserController@accountSettings'
	]);
	Route::put('change_avatar/{user}', 'UserController@changeAvatar')->name('users.change_avatar');
	Route::put('change_password/{user}', 'UserController@changePassword')->name('users.change_password');
	Route::get('user_activate/{user}', 'UserController@activate')->name('users.activate');
	Route::get('user_deactivate/{user}', 'UserController@deactivate')->name('users.deactivate');
	// restore
	Route::post('users_restore/{user}', [
		'as' => 'users.restore',
		'uses' => 'UserController@restore'
	]);
    
    Route::resource('permissions', 'Configuration\RolePermission\PermissionController');
	// Route::get('/permissions_get_data', 'Configuration\RolePermission\PermissionController@get_data')->name('permissions.get_data');
	// restore
	Route::post('permissions/restore/{department}', [
		'as' => 'permissions.restore',
		'uses' => 'Configuration\RolePermission\PermissionController@restore'
	]);

	/**
	 * Department
	 */
	Route::resource('departments', 'DepartmentController');
	// restore
	Route::post('departments_restore/{department}', [
		'as' => 'departments.restore',
		'uses' => 'DepartmentController@restore'
	]);

	/**
	 * Faculty
	 */
	/* Route::resource('faculties', 'Configuration\FacultyController')->parameters([
		'faculties' => 'faculty'
	]); */
	Route::resource('faculties', 'FacultyController');
	Route::put('faculties_update_avatar/{faculty}', 'FacultyController@changeAvatar')->name('faculties.change_avatar');
	// restore
	Route::post('faculties_restore/{position}', [
		'as' => 'faculties.restore',
		'uses' => 'FacultyController@restore'
	]);

	/**
	 * Student
	 */
	Route::resource('students', 'StudentController');
	Route::put('students_update_avatar/{student}', 'StudentController@changeAvatar')->name('students.change_avatar');
	// restore
	Route::post('students_restore/{position}', [
		'as' => 'students.restore',
		'uses' => 'StudentController@restore'
	]);

	/**
	 * Question
	 */
	Route::resource('questions', 'QuestionController');
	// restore
	Route::post('questions_restore/{question}', [
		'as' => 'questions.restore',
		'uses' => 'QuestionController@restore'
	]);

	/**
	 * Evaluation
	 */
	Route::resource('evaluations', 'EvaluationController');
	// restore
	Route::post('evaluations_restore/{evaluation}', [
		'as' => 'evaluations.restore',
		'uses' => 'EvaluationController@restore'
	]);

	/**
	 * Evaluation Student
	 */
	Route::resource('evaluation_students', 'EvaluationStudentController')->only([
		'create', 'store', 'show'
	]);
	// restore
	/* Route::post('evaluation_students_restore/{evaluationStudent}', [
		'as' => 'evaluation_students.restore',
		'uses' => 'EvaluationStudentController@restore'
	]); */

	/**
	 * Evaluation Classes
	 */
	Route::resource('evaluation_classes', 'EvaluationClassesController')->parameters([
		'evaluation_classes' => 'evaluationClasses'
	])->only([
		'show', 'delete'
	]);
	// restore
	Route::post('evaluation_classes_restore/{evaluationClasses}', [
		'as' => 'evaluation_classes.restore',
		'uses' => 'EvaluationClassesController@restore'
	]);
	Route::get('evaluation_class/export/', 'EvaluationClassesController@export')->name('evaluation_classes.export');
	Route::get('evaluation_class/send_email/{evaluationClasses}', 'EvaluationClassesController@mailToFaculty')->name('evaluation_classes.send_email');
	/* Route::post('evaluation_students_restore/{evaluationStudent}', [
		'as' => 'evaluation_students.restore',
		'uses' => 'EvaluationStudentController@restore'
	]); */

	/**
	 * Courses
	 */
	Route::resource('courses', 'CourseController');
	// restore
	Route::post('courses_restore/{course}', [
		'as' => 'courses.restocoursesre',
		'uses' => 'CourseController@restore'
	]);

	/**
	 * Classes
	 */
	Route::resource('classes', 'ClassesController')->parameters([
		'classes' => 'classes'
	]);
	// restore
	Route::post('classes_restore/{classes}', [
		'as' => 'classes.restore',
		'uses' => 'ClassesController@restore'
	]);
	Route::get('classes_set_active/{classes}', 'ClassesController@setActive')->name('classes.set_active');
	Route::get('classes_set_inactive/{classes}', 'ClassesController@setInactive')->name('classes.set_inactive');

	/**
	 * Class Students
	 */
	Route::resource('class_students', 'ClassStudentController')->parameters([
		'class_students' => 'classStudent'
	]);
	Route::post('class_students_restore/{classStudent}', [
		'as' => 'class_students.restore',
		'uses' => 'ClassStudentController@restore'
	]);
});
/**	
 * Dev
 */
Route::post('insert_student', ['as' => 'dummy_identity.insert_student', 'uses' => 'RandomIdentityController@insert_student']);
Route::post('insert_faculty', ['as' => 'dummy_identity.insert_faculty', 'uses' => 'RandomIdentityController@insert_faculty']);
