<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('is_active');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('faculty_id');
            $table->string('section')->nullable();
            $table->string('school_year')->nullable();
            $table->string('schedule')->nullable();
			$table->timestamps();
            $table->softDeletes();

            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
				->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('faculty_id')
                ->references('id')
                ->on('faculties')
				->onDelete('cascade')
                ->onUpdate('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classes');
    }
}
