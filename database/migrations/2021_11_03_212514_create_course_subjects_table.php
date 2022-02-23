<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('course_id');
            $table->integer('year_level');
            $table->enum('semester', ['1st', '2nd', '3rd'])->nullable();
            $table->unsignedBigInteger('subject_id');
            $table->timestamps();

            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
				->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects')
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
        Schema::dropIfExists('course_subjects');
    }
}
