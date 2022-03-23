<?php

namespace Themosis\Twig\Tests;

use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\Container as ContainerInterface;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\View\ViewServiceProvider;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Themosis\Twig\TwigServiceProvider
 */
class TwigTest extends TestCase
{
    protected ContainerInterface $app;

    protected function setUp(): void
    {
        $app = new Container();

        $repository = new Repository([
            'view' => [
                'paths' => [
                    'toto'
                ]
            ],
        ]);

        $app['config'] = $repository;

        (new FilesystemServiceProvider($app))
            ->register();

        (new ViewServiceProvider($app))
            ->register();

        $this->app = $app;
    }

    /**
     * @test
     */
    public function it_can_load_twig_engine(): void
    {
        $this->assertTrue(true);
    }
}