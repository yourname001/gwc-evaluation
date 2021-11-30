<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationStudentResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_student_responses', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->unsignedBigInteger('evaluator_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('evaluation_student_id');
            $table->text('question');
            $table->enum('answer', ['strongly agree', 'agree', 'disagree', 'strongly disagree']);
			$table->timestamps();
            $table->softDeletes();

            $table->foreign('evaluation_student_id')
                ->references('id')
                ->on('evaluation_students')
				->onDelete('cascade')
                ->onUpdate('cascade');
            /* $table->foreign('question_id')
                ->references('id')
                ->on('questions')
				->onDelete('cascade')
                ->onUpdate('cascade'); */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_student_responses');
    }
}
