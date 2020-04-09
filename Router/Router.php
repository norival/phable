<?php

namespace Norival\Phable\Router;

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
     * @return void
     */
    public function resolve(string $pattern): void
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
        $controller       = new $controllerClass();

        if (!empty($parameters)) {
            $controller->$controllerMethod($parameters);

            return ;
        }

        $controller->$controllerMethod();
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
