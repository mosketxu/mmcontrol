<?php

namespace App\Providers;

use App\Models\EntidadTipo;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;

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
    public function boot(){
        // Jetstream 2.x registraba sus componentes con el prefijo "jet-" (ej.
        // <x-jet-button>). Jetstream 5 espera que se publiquen sin prefijo en
        // resources/views/components, pero esta app ya tiene sus propios
        // componentes genericos con esos mismos nombres (button, modal, dropdown,
        // input...) usados fuera de las paginas de auth/Jetstream. Para no
        // colisionar, mantenemos las vistas publicadas de Jetstream en
        // resources/views/vendor/jetstream/components y las registramos bajo el
        // prefijo "jet-" como antes.
        Blade::anonymousComponentPath(resource_path('views/vendor/jetstream/components'), 'jet');

        // Using view composer to set following variables globally
        // view()->composer('*',function($view) {
        //         $view->with('tiposentidad', EntidadTipo::orderBy('id')->get());
        // });
        Builder::macro('search', function ($field, $string) {
            return $string ? $this->where($field, 'like', '%'.$string.'%') : $this;
        });
        Builder::macro('orSearch', function ($field, $string) {
            return $string ? $this->orWhere($field, 'like', '%'.$string.'%') : $this;
        });
        Builder::macro('searchYear',function($field,$string){
            return $string ? $this->whereYear($field, 'like', '%'.$string.'%'): $this;
        });
        Builder::macro('searchMes',function($field,$string){
            return $string ? $this->whereMonth($field, 'like', '%'.$string.'%'): $this;
        });
        Builder::macro('searchMes2',function($field,$string){
            return $string ? $this->whereMonth($field,$string): $this;
        });


        Builder::macro('toCsv', function () {
            $results = $this->get();

            if ($results->count() < 1) return;

            $titles = implode(',', array_keys((array) $results->first()->getAttributes()));

            $values = $results->map(function ($result) {
                return implode(',', collect($result->getAttributes())->map(function ($thing) {
                    return '"'.$thing.'"';
                })->toArray());
            });

            $values->prepend($titles);

            return $values->implode("\n");
        });

    }
}
