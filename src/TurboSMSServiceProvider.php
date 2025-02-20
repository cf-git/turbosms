<?php

namespace Daaner\TurboSMS;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class TurboSMSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Str::macro("of", function ($string) {
            return new Stringable($string);
        });

        $this->publishes([
            __DIR__.'/../config/turbosms.php' => config_path('turbosms.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../resources/lang' => "{$this->app['path.lang']}/vendor/turbosms",
        ]);

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/', 'turbosms');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/turbosms.php', 'turbosms');

        $this->app->singleton('turbosms', function () {
            return $this->app->make(TurboSMS::class);
        });

        $this->app->alias('turbosms', 'TurboSMS');
    }
}
