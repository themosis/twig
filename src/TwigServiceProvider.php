<?php

namespace Themosis\Twig;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Twig\Loader\FilesystemLoader;

class TwigServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerTwigLoader();
    }

    public function registerTwigLoader(): void
    {
        $this->app->singleton('twig.loader', function (Container $app) {
            return new FilesystemLoader($app['view.finder']);
        });
    }
}