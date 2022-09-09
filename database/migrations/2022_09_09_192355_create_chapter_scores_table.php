<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapterScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter_scores', function (Blueprint $table) {
            $table->id();
            $table->integer("total_marks");
            $table->integer("obtained_marks");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("subject_id");
            $table->unsignedBigInteger("chapter_id");
            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('chapter_id')->references('id')->on('chapters');
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
        Schema::dropIfExists('chapter_scores');
    }
}
