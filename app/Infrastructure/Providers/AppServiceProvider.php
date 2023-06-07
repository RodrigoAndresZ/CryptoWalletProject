<?php

namespace App\Infrastructure\Providers;

use App\Application\DataSource\CoinDataSource;
use App\Application\DataSource\UserDataSource;
use App\Application\DataSource\WalletDataSource;
use App\Infrastructure\Persistence\CacheWalletDataSource\CacheWalletDataSource;
use App\Infrastructure\Persistence\CoinLoreDataSource;
use App\Infrastructure\Persistence\FileUserDataSource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(WalletDataSource::class, CacheWalletDataSource::class);
        $this->app->bind(UserDataSource::class, FileUserDataSource::class);
        $this->app->bind(CoinDataSource::class, CoinLoreDataSource::class);
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
