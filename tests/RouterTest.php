<?php

namespace Norival\Phable\tests;

use Norival\Phable\Router\Route;
use Norival\Phable\Router\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private \Norival\Phable\Router\Router $router;

    public function setUp(): void
    {
        parent::setUp();

        $this->router = new Router();
    }

    public function testCanBeCreated(): void
    {
        $this->assertInstanceOf(Router::class, $this->router);
        /* $this->assertInstanceOf(Router::class, $this->router); */
    }

    public function testCanAddRoute(): void
    {
        $this->router->addRoute('home', '/home/', 'HomeController@index');

        $this->assertIsArray(
            $this->router->getRoutes(),
            'Router::getRoutes() should return an array'
        );
        $this->assertInstanceOf(Route::class, $this->router->getRoutes()[0]);
    }
}
