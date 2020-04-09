<?php

namespace Norival\Phable\Router;

interface RouteInterface
{
    public function match(string $pattern): bool;
    public function getController(): array;
    public function getParameters(): array;
}
