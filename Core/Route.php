<?php

namespace Norival\Spine\Core;

/**
 * Route class
 *
 * @author Xavier Laviron <xavier@norival.dev>
 * @see RouteInterface
 */
class Route
{
    private string $controller;
    private string $method;
    private string $name;
    private string $pattern;
    private array $parameters;

    /**
     * Route constructor
     *
     * @param  string $name
     * @param  string $pattern
     * @param  string $controller
     * @param  string $method
     */
    public function __construct(string $name, string $pattern, string $controller, string $method = 'GET')
    {
        $this->controller = $controller;
        $this->method     = $method;
        $this->name       = $name;
        $this->pattern    = $pattern;

        $this->parameters = $this->fillParameters();
        /* var_dump($this->parameters); */
    }

    /**
     * Whether a route match or not
     *
     * @param  string $uri
     * @param  string $method
     * @return bool
     */
    public function match(string $uri, string $method): bool
    {
        if ($method !== $this->method) {
            return false;
        }

        $pattern      = explode('/', trim($uri, '/'));
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
    private function fillParameters(): array
    {
        $chunks = explode('/', trim($this->pattern, '/'));
        $parameters = [];

        for ($i = 0; $i < count($chunks); $i++) {
            if (preg_match('/^{.*}$/', $chunks[$i])) {
                $name = preg_replace('/{|}/', '', $chunks[$i]);
                $parameters[$i] = $name;
            }
        }

        return $parameters;
    }

    /**
     * Extract route parameters for a given path
     *
     * @param  string $path
     * @return array
     */
    public function extractParameters(string $path): array
    {
        if (empty($this->parameters)) {
            return [];
        }

        $parameters = [];
        $chunks = explode('/', trim($path, '/'));

        foreach ($this->parameters as $index => $name) {
            $parameters[$name] = $chunks[$index];
        }

        return $parameters;
    }
}
