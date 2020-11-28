<?php

namespace App\Providers;

use App\Persona;
use Illuminate\Support\ServiceProvider;
use Auth;
use App\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($view) {
        if (Auth::guest()) {
            $personas_logueadas = [];
        } else {



            $personas_logueadas = User::find(Auth::user()->id)->persona()->first();

            // $control_mesas_votacion = \DB::table('votos_presidenciales')
            // ->select(
            //     'votos_presidenciales.id_mesa',
            //     \DB::raw('SUM(votos_presidenciales.validos) as validos')
            // )
            // ->groupBy('id_mesa')
            // ->get();

        }
        $view->with('personas_logueadas', $personas_logueadas);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

