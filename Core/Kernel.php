<?php

namespace Norival\Spine\Core;

use Norival\Spine\Exceptions\NoRouteException;
use Norival\Spine\Core\Router;

/**
 * Kernel class
 *
 * @author Xavier Laviron <xavier@norival.dev>
 */
class Kernel
{
    private \Norival\Spine\Core\Router $router;

    public function __construct()
    {
    }

    /**
     * Boot the kernel: load configuration, instantiate the router and load
     * routes definitions
     *
     * @return self
     */
    public function boot(string $configFile): self
    {
        /* @var $routes \Spine\Core\Route[] */
        $routes = [];

        // TODO load configuration

        // TODO load routes from php file
        if (!\file_exists($configFile)) {
            throw new NoRouteException('No route configuration file found');
        }

        // instantiate the Router
        $this->router = new Router();

        // read the configuration file
        require $configFile;

        foreach ($routes as $name => $route) {
            $this->router->addRoute($name, $route['path'], $route['controller']);
        }

        return $this;
    }

    /**
     * Handle the request
     *
     * @return void
     */
    public function handleRequest(): void
    {
        // TODO constuct a request object and call the router
    }

    /**
     * Dump routes: for debugging
     *
     * @return string[]
     */
    public function dumpRoutes()
    {
        return $this->router->getRoutes();
    }
}
