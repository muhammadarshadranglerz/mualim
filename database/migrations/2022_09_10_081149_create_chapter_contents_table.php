<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapterContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter_contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('note');
            $table->string('video')->nullable();
            $table->string('file')->nullable();
            $table->unsignedBigInteger('chapter_id');
            $table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('cascade');
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
        Schema::dropIfExists('chapter_contents');
    }
}
