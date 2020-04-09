<?php

namespace Norival\Phable\Router;

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
     * @param  array $controller
     * @return self
     */
    public function addRoute(string $name, string $path, array $controller): self
    {
        $this->routes[] = new Route(
            $name,
            $path,
            $controller
        );

        return $this;
    }

    public function resolve(string $pattern): void
    {
        $controllerClass  = null;
        $controllerMethod = null;
        $parameters       = null;

        foreach ($this->routes as $route) {
            if ($route->match($pattern)) {
                $controllerClass  = $route->getController()[0];
                $controllerMethod = $route->getController()[1];
                $parameters       = $route->getParameters();

                break;
            }
        }

        if (!$controllerClass) {
            throw new \Exception('not found');
        }

        // call controller method
        $controller = new $controllerClass();
        if (!empty($parameters)) {
            $controller->$controllerMethod($parameters);

            return ;
        }

        $controller->$controllerMethod();
    }
}
