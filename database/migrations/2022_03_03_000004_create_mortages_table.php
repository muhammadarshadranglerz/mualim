<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMortagesTable extends Migration
{
    public function up()
    {
        Schema::create('mortages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');            
            $table->integer('loandamoutn')->nullable();
            $table->integer('downpayment')->nullable();
            $table->string('percentage')->nullable();
            $table->string('loan_terms')->nullable();
            $table->string('start_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
