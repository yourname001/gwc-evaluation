<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('evaluation_id');
            $table->unsignedBigInteger('class_id');
			$table->timestamps();
            $table->softDeletes();

            $table->foreign('evaluation_id')
                ->references('id')
                ->on('evaluations')
				->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('class_id')
                ->references('id')
                ->on('classes')
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
        Schema::dropIfExists('evaluation_classes');
    }
}
