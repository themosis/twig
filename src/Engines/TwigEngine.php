<?php

namespace Themosis\Twig\Engines;

use Illuminate\Contracts\View\Engine;
use Illuminate\View\FileViewFinder;
use Twig\Environment;

class TwigEngine implements Engine
{
    protected string $extension = '.twig';

    public function __construct(
        protected Environment $twig,
        protected FileViewFinder $finder,
    ) {
    }

    public function get($path, array $data = []): string
    {
        $name = array_search($path, $this->finder->getViews());

        return $this->twig->render(
            $this->parseFileName($name).$this->extension,
            $data
        );
    }

    protected function parseFileName(string $name): string
    {
        return str_replace('.', DIRECTORY_SEPARATOR, $name);
    }
}
