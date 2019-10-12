<?php

namespace App\Providers;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public static $hydratedModels = 0;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $this->registerQueryBuilderMacros();
    }

    protected function registerQueryBuilderMacros(){
        Builder::macro('addSubSelect', function ($column, $query) {
            if (is_null($this->columns)) {
                $this->select($this->from.'.*');
            }

            return $this->selectSub($query, $column);
        });
    }
}
