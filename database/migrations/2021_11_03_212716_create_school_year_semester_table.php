<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolYearSemesterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_year_semester', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('active')->nullable()->default(0);
            $table->integer('semester');
            $table->string('school_year');
            $table->string('start_date');
            $table->string('end_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_year_semester');
    }
}
