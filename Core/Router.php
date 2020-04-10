<?php

namespace Norival\Spine\Core;

use Norival\Spine\Core\Route;

/**
 * Router class
 *
 * @author Xavier Laviron <xavier@norival.dev>
 */
class Router
{
    /** @var RouteInterface[] $routes */
    private $routes;

    public function __construct()
    {
    }

    /**
     * Add a new route
     *
     * @param  string $name
     * @param  string $path
     * @param  string $controller
     * @return self
     */
    public function addRoute(string $name, string $path, string $controller): self
    {
        $this->routes[] = new Route(
            $name,
            $path,
            $controller
        );

        return $this;
    }

    /**
     * Resolve a route from a pattern
     *
     * @param  string $pattern
     * @throws \Exception
     * @return int
     */
    public function resolve(string $pattern)
    {
        $controller = null;
        $parameters = null;

        foreach ($this->routes as $route) {
            if ($route->match($pattern)) {
                $controller = explode('@', $route->getController());
                $parameters = $route->getParameters();

                break;
            }
        }

        if (!$controller) {
            throw new \Exception('not found');
        }

        // call controller method
        $controllerClass  = $controller[0];
        $controllerMethod = $controller[1];

        if (!\class_exists($controllerClass)) {
            throw new \Exception('Class not found');
        }

        $controller = new $controllerClass();

        if (!empty($parameters)) {
            $controller->$controllerMethod($parameters);

            return 1;
        }

        $controller->$controllerMethod();

        return 1;
    }

    /**
     * Get all the routes
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
