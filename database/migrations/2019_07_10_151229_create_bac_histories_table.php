<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBacHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bac_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('action');
            $table->integer('bac_id')->unsigned();
            $table->foreign('bac_id')->references('id')->on('bacs')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('machine_rental_id')->unsigned();
            $table->foreign('machine_rental_id')->references('id')->on('machine_rentals')->onDelete('cascade');
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
        Schema::dropIfExists('bac_histories');
    }
}
