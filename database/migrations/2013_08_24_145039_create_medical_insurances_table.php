<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_insurances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('business_name');
            $table->BigInteger('cuit')->unique();
            $table->string('email');
            $table->string('contact_phone');
            $table->enum('type', ['prepaga', 'obra social', 'otro']);
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
        Schema::dropIfExists('medical_insurances');
    }
}
