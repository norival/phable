<?php

namespace Norival\Phable\tests;

use Norival\Phable\Controller\AbstractController;
use Norival\Phable\Router\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    private \Norival\Phable\Router\Route $route;
    private \Norival\Phable\Router\Route $routeWithSlug;

    public function setUp(): void
    {
        parent::setUp();

        $this->route = new Route('test', '/test/route', 'HomeController@index');
        $this->routeWithSlug = new Route('test', '/test/route/{slug}', 'HomeController@test');
    }

    public function testCanBeCreated(): void
    {
        $this->assertInstanceOf(
            Route::class,
            $this->route
        );

        $this->assertInstanceOf(
            Route::class,
            $this->routeWithSlug
        );
    }

    public function testMatchMethodNoSlug(): void
    {
        $this->assertTrue($this->route->match('/test/route'));
        $this->assertTrue($this->route->match('/test/route/'));
        $this->assertFalse($this->route->match('/test/route/test'));
    }

    public function testMatchMethodWithSlug(): void
    {
        $this->assertTrue($this->routeWithSlug->match('/test/route/string'));
        $this->assertTrue($this->routeWithSlug->match('/test/route/string/'));
        $this->assertFalse($this->routeWithSlug->match('/test/route/string/string'));
    }

    public function testGetParameters(): void
    {
        $this->assertEmpty($this->route->getParameters());
        $this->assertCount(1, $this->routeWithSlug->getParameters());
        $this->assertArrayHasKey('slug', $this->routeWithSlug->getParameters());
    }
}
