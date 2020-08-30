<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->BigInteger('cuit')->unique()->nullable();
            $table->unsignedBigInteger('address_id')->nullable()->index();
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->string('contact_phone');
            $table->string('email');
            $table->string('category_id');
            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('establishment_id');
            // $table->foreign('establishments_id')->references('id')->on('establishment')->onDelete('cascade');
            $table->string('website')->nullable();
            //MANAGER_ID? QUIEN GESTIONA TODOS LOS TURNOS DE QUIENTES TRABAJAN AQUI
            $table->string('avatar')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
