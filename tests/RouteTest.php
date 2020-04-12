<?php

namespace Norival\Spine\tests;

use Norival\Spine\Core\AbstractController;
use Norival\Spine\Core\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    private \Norival\Spine\Core\Route $route;
    private \Norival\Spine\Core\Route $routeWithSlug;

    public function setUp(): void
    {
        parent::setUp();

        $this->route = new Route('test', '/test/route', 'HomeController@index', 'GET');
        $this->routeWithSlug = new Route('test', '/test/route/{slug}', 'HomeController@test', 'GET');
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
        $this->assertTrue($this->route->match('/test/route', 'GET'));
        $this->assertTrue($this->route->match('/test/route/', 'GET'));
        $this->assertFalse($this->route->match('/test/route/test', 'GET'));
        $this->assertFalse($this->route->match('/test/route', 'POST'));
    }

    public function testMatchMethodWithSlug(): void
    {
        $this->assertTrue($this->routeWithSlug->match('/test/route/string', 'GET'));
        $this->assertTrue($this->routeWithSlug->match('/test/route/string/', 'GET'));
        $this->assertFalse($this->routeWithSlug->match('/test/route/string', 'POST'));
        $this->assertFalse($this->routeWithSlug->match('/test/route/string/string', 'GET'));
    }

    public function testGetParameters(): void
    {
        $this->assertEmpty($this->route->getParameters());
        $this->assertCount(1, $this->routeWithSlug->getParameters());
        $this->assertArrayHasKey(2, $this->routeWithSlug->getParameters());
        $this->assertEquals('slug', $this->routeWithSlug->getParameters()[2]);
    }

    public function testExtractParameters(): void
    {
        $this->assertIsArray($this->routeWithSlug->extractParameters('/test/route/value'));
        $this->assertCount(1, $this->routeWithSlug->extractParameters('/test/route/value'));
        $this->assertEquals('value', $this->routeWithSlug->extractParameters('/test/route/value')['slug']);
    }
}
