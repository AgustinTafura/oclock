<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('address_id')->nullable()->index();
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->date('birthdate')->nullable();
            $table->BigInteger('dni')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->enum('sex', ['male', 'female', 'other'])->nullable();
            // $table->unsignedBigInteger('provider_id')->nullable();;
            // $table->foreign('manager_id')->references('id')->on('managers')->onDelete('cascade');;
            $table->boolean('is_admin')->default('0');
            // $table->integer('manager_id')->unsigned()->nullable();
            $table->string('avatar')->default('storage/img/agenda.jpg');
            $table->boolean('active')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
