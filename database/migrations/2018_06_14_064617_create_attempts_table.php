<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attempts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token');
            $table->integer('questionnaire_id')->unsigned();
            $table->integer('current_question_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->integer('score')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('current_question_id')
                ->references('id')->on('questions')
                ->onDelete('cascade');

            $table->foreign('questionnaire_id')
                ->references('id')->on('questionnaires')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attempts');
    }
}
