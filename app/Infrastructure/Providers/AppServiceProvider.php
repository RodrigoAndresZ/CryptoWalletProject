<?php

namespace App\Infrastructure\Providers;

use App\Application\UserDataSource\UserRepository;
use App\DataSource\Database\EloquentUserDataSource;
use Illuminate\Support\ServiceProvider;

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
//        $this->app->bind(UserRepository::class, function () {
//            return new EloquentUserDataSource();
//        });
    }
}
