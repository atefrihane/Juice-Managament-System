<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('status');
            $table->string('designation');
            $table->string('sign');
            $table->string('country');
            $table->string('city');
            $table->string('zip_code');
            $table->string('address');
            $table->string('complement')->nullable();
            $table->string('email');
            $table->string('tel');
            $table->string('comment');
            $table->string('photo');
            $table->string('bill_type');
            $table->string('openingHour');
            $table->string('closureHour');
            $table->json('closedDays');
            $table->integer('super_visor_id')->unsigned();
            $table->foreign('super_visor_id')->references('id')->on('super_visors');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');

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
        Schema::dropIfExists('stores');
    }
}
