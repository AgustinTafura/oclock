<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('street');
            $table->integer('number');
            $table->string('postal_code');
            $table->string('floor')->nullable();
            $table->string('apartment')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->float('lat', 10,6)->nullable();
            $table->float('lng', 10,6)->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
