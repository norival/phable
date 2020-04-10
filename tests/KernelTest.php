<?php

namespace Norival\Spine\tests;

use Norival\Spine\Exceptions\NoRouteException;
use Norival\Spine\Core\Kernel;
use Norival\Spine\Core\Route;
use PHPUnit\Framework\TestCase;

class KernelTest extends TestCase
{
    private $kernel;

    public function setUp(): void
    {
        $this->kernel = new Kernel();
    }

    public function testException(): void
    {
        $this->expectException(NoRouteException::class);
        $this->expectExceptionMessage('No route configuration file found');

        $this->kernel->boot('nofile.php');
    }

    public function testBoot(): void
    {
        /* $this->expectNotToPerformAssertions(); */
        $this->kernel->boot('tests/test_routes.php');

        $this->assertCount(2, $this->kernel->dumpRoutes());
        $this->assertInstanceOf(Route::class, $this->kernel->dumpRoutes()[0]);
    }

/*     public function testHandleRequest() */
/*     { */
/*         /1* $path = *1/ */
/*     } */
}
