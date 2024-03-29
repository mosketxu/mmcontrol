<?php

namespace App\Providers;

use App\Models\EntidadTipo;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

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
