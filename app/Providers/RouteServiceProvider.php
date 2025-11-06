<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * La ruta a la que se redirige a los usuarios después del inicio de sesión o registro.
     */
    public const HOME = '/';

    /**
     * Bootstrap de los servicios de la aplicación.
     */
    public function boot(): void
    {
        //
    }
}
