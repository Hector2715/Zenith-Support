<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;

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
    public function boot()
    {
        // Establece el idioma de Carbon a español
        Carbon::setLocale('es');
        
        // Opcional: Establecer el locale del sistema (esto ayuda en algunos servidores)
        setlocale(LC_TIME, 'es_ES.utf8', 'es_ES', 'spanish');
    }
}
