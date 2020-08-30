<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->BigInteger('cuit')->nullable();
          $table->BigInteger('license_number')->nullable();
          $table->string('contact_phone')->nullable();
          $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          // $table->unsignedBigInteger('address_id')->nullable();
          //   $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
          $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies') //->onDelete('cascade');
          $table->unsignedBigInteger('specialty_id')->nullable();
            $table->foreign('specialty_id')->references('id')->on('specialties')->onDelete('cascade');
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
        Schema::dropIfExists('providers');
    }
}
