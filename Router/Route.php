<?php

namespace Norival\Phable\Router;

/**
 * Route class
 *
 * @author Xavier Laviron <xavier@norival.dev>
 * @see RouteInterface
 */
class Route implements RouteInterface
{
    private string $name;
    private string $pattern;
    private string $controller;
    private array $parameters;

    /**
     * Route constructor
     *
     * @param  string $name
     * @param  string $pattern
     * @param  string $controller
     */
    public function __construct(string $name, string $pattern, string $controller)
    {
        $this->name       = $name;
        $this->pattern    = $pattern;
        $this->controller = $controller;

        $this->parameters = $this->extractParameters();
        /* var_dump($this->parameters); */
    }

    /**
     * Whether a route match or not
     *
     * @param  string $pattern
     * @return bool
     */
    public function match(string $pattern): bool
    {
        $pattern      = explode('/', trim($pattern, '/'));
        $routePattern = explode('/', trim($this->pattern, '/'));

        if (count($pattern) !== count($routePattern)) {
            return false;
        }

        for ($i = 0; $i < count($routePattern); $i++) {
            if (preg_match('/^{.*}$/', $routePattern[$i])) {
                continue;
            }

            if ($pattern[$i] === $routePattern[$i]) {
                continue;
            }

            return false;
        }

        return true;
    }

    /**
     * Get the controller associated with the route
     *
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * Get the route parameters
     *
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Extract route parameters from slugs
     *
     * @return array
     */
    private function extractParameters(): array
    {
        $pattern = explode('/', trim($this->pattern, '/'));
        $parameters = [];

        for ($i = 0; $i < count($pattern); $i++) {
            if (preg_match('/^{.*}$/', $pattern[$i])) {
                $name = preg_replace('/{|}/', '', $pattern[$i]);
                $parameters[$name] = 'condition';
            }
        }

        return $parameters;
    }
}
