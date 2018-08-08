<?php
/**
 * Created by PhpStorm.
 * User: haoqi
 * Date: 2018/8/8
 * Time: 16:01
 */

namespace Crius\Smy\Providers;

use Illuminate\Support\ServiceProvider;

class CriusSmyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/route.php');
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->publishes([
            __DIR__ . '/config/smyConfig.php' => config_path('smyConfig.php'),
            __DIR__ . '/config/smySupportBank.php' => config_path('smySupportBank.php'),
            __DIR__ . '/assets' => public_path('vendor/smy'),
        ]);
        $this->mergeConfigFrom(__DIR__ . '/config/smyConfig.php', 'smyConfig');
        $this->mergeConfigFrom(__DIR__ . '/config/smySupportBank.php', 'smySupportBank');
    }

}