<?php

namespace Norival\Phable\Router;

interface RouteInterface
{
    public function match(string $pattern): bool;
    public function getController(): string;
    public function getParameters(): array;
}
