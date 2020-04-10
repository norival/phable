<?php

namespace Norival\Spine\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    public function render(string $template, array $variables = []): void
    {
        $loader = new FilesystemLoader('../templates');
        $twig   = new Environment($loader);

        echo $twig->render($template, $variables);
    }
}
