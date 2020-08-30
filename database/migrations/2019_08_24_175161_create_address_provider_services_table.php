<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressProviderServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_provider_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('address_id')->nullable()->index();
            $table->foreign('address_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('provider_id')->nullable()->index();
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
            $table->unsignedBigInteger('service_id')->nullable()->index();
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
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
        Schema::dropIfExists('address_provider_services');
    }
}
