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
            $table->unsignedBigInteger('school_year_semester_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('faculty_id');
            $table->string('section')->nullable();
            $table->string('schedule')->nullable();
			$table->timestamps();
            $table->softDeletes();

            $table->foreign('school_year_semester_id')
                ->references('id')
                ->on('school_year_semester')
				->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects')
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
