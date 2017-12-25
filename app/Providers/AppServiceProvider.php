<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->singleton(
        //     \App\Repositories\Product\ProductRepositoryInterface::class,
        //     \App\Repositories\Product\ProductEloquentRepository::class,

        //     \App\Repositories\Profile\ProfileRepositoryInterface::class,
        //     \App\Repositories\Profile\ProfileEloquentRepository::class
        // );
        $models = array(
            'Product',
            'Profile',
        );

        foreach ($models as $model) {
            $this->app->bind("App\Repositories\\{$model}\\{$model}RepositoryInterface", 
            "App\Repositories\\{$model}\\{$model}EloquentRepository");
        }
    }
}
