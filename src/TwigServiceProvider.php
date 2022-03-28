<?php

namespace Themosis\Twig;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Factory;
use Themosis\Twig\Engines\TwigEngine;
use Themosis\Twig\Extensions\WordPressExtension;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class TwigServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/twig.php' => config_path('twig.php'),
        ]);
    }

    public function register()
    {
        $this->registerTwigLoader();
        $this->registerTwigEnvironment();
        $this->registerTwigEngine();
    }

    public function registerTwigLoader(): void
    {
        $this->app->singleton('twig.loader', function (Container $app) {
            return new FilesystemLoader($app['view.finder']->getPaths());
        });
    }

    public function registerTwigEnvironment(): void
    {
        $this->app->singleton('twig', function ($app) {
            $twig = new Environment(
                $app['twig.loader'],
                [
                    'auto_reload' => $app['config']['twig.auto_reload'],
                    'cache' => $app['config']['twig.cache'],
                    'debug' => $app['config']['twig.debug'],
                    'strict_variables' => $app['config']['twig.strict_variables']
                ]
            );

            $twig->addExtension(new DebugExtension());
            $twig->addExtension(new WordPressExtension());

            return $twig;
        });
    }

    public function registerTwigEngine(): void
    {
        /** @var Factory $factory */
        $factory = $this->app['view'];

        $factory->addExtension('twig', 'twig', function () use ($factory) {
            return new TwigEngine($this->app['twig'], $factory->getFinder());
        });
    }
}
