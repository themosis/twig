<?php

namespace Themosis\Twig\Tests;

use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\Container as ContainerInterface;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\View\Factory;
use Illuminate\View\ViewServiceProvider;
use PHPUnit\Framework\TestCase;
use Themosis\Twig\TwigServiceProvider;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * @covers \Themosis\Twig\TwigServiceProvider
 * @covers \Themosis\Twig\Engines\TwigEngine
 * @covers \Themosis\Twig\Extensions\WordPressExtension
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
                    realpath(__DIR__.'/views')
                ]
            ],
            'twig' => [
                'auto_reload' => true,
                'cache' => __DIR__.'/cache',
                'debug' => true,
                'strict_variables' => true,
            ]
        ]);

        $app['config'] = $repository;

        (new FilesystemServiceProvider($app))
            ->register();

        (new EventServiceProvider($app))
            ->register();

        (new ViewServiceProvider($app))
            ->register();

        $this->app = $app;
    }

    /**
     * @test
     */
    public function it_can_load_twig_services(): void
    {
        (new TwigServiceProvider($this->app))
            ->register();

        $this->assertInstanceOf(FilesystemLoader::class, $this->app['twig.loader']);
        $this->assertInstanceOf(Environment::class, $this->app['twig']);

        /** @var Factory $factory */
        $factory = $this->app['view'];

        $this->assertTrue(in_array('twig', array_values($factory->getExtensions())));
    }

    /**
     * @test
     */
    public function it_can_compile_twig_views(): void
    {
        (new TwigServiceProvider($this->app))
            ->register();

        /** @var Factory $factory */
        $factory = $this->app['view'];

        $intro = $factory->make('intro', [
            'name' => 'Julien'
        ])->render();

        $this->assertStringContainsString('<h1>Intro Twig Template</h1>', $intro);
        $this->assertStringContainsString('Julien', $intro);

        $about = $factory->make('pages.about', [
            'company' => new Company('Themosis Corporation'),
            'people' => [
                [
                    'name' => 'Julien',
                    'role' => 'Developer',
                ],
                [
                    'name' => 'Carla',
                    'role' => 'Designer'
                ]
            ]
        ])->render();

        $this->assertStringContainsString('Themosis Corporation', $about);
        $this->assertStringContainsString('<p>Julien<span>Developer</span></p>', $about);
        $this->assertStringContainsString('<p>Carla<span>Designer</span></p>', $about);
    }
}

class Company
{
    public function __construct(public string $name)
    {
    }
}
