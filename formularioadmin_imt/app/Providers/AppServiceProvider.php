<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Alinear la zona horaria de PHP y la sesión de MySQL con la configuración de la app
        try {
            $timezone = Config::get('app.timezone', 'America/Mexico_City');
            if ($timezone) {
                // Fija la zona horaria de PHP
                @date_default_timezone_set($timezone);
                // Para MySQL TIMESTAMP, fija la zona de la sesión con offset actual (funciona sin tablas de timezones)
                @DB::statement("SET time_zone = '" . date('P') . "'");
            }
        } catch (\Throwable $e) {
            // Evita que un error de DB en el boot rompa la aplicación
        }
    }
}
