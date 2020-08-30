<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable()->index();
              $table->foreign('user_id')->references('id')->on('users');// ->onDelete('cascade'); Porque si se elimina el user, se elimina el turno.
            $table->unsignedBigInteger('address_id')->nullable()->index();
              $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->unsignedBigInteger('provider_id')->nullable()->index();
              $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
            $table->unsignedBigInteger('specialty_id');
              $table->foreign('specialty_id')->references('id')->on('specialties')->onDelete('cascade');
            $table->unsignedBigInteger('service_id')->nullable()->index();
              $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->unsignedBigInteger('status_id')->nullable()->index();
              $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            // Info dia y timepo, esta ok?
            $table->dateTime('start_time');
            $table->dateTime('finish_time');
            $table->boolean('active');
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
        Schema::dropIfExists('bookings');
    }
}
