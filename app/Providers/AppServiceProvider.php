<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // porque se agrego arriba "use Illuminate\Support\Facades\Schema; // Si no se pone esto, a vece sal hacer las migraciones te puede tirar error por no tener  una longitud standar para crear los campos
        // Schema::defaultStringLength(191);  // es la longitud que van a tener los campos que se van a acrear en la DB
    }
}
