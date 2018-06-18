<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attempt_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->integer('option_id')->unsigned();

            $table->foreign('attempt_id')
                ->references('id')->on('attempts')
                ->onDelete('cascade');
            $table->foreign('question_id')
                ->references('id')->on('questions')
                ->onDelete('cascade');
            $table->foreign('option_id')
                ->references('id')->on('options')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
