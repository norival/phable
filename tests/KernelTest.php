<?php

namespace Norival\Phable\tests;

use Norival\Phable\Exceptions\NoRouteException;
use Norival\Phable\Kernel\Kernel;
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
        $this->kernel->boot('tests/test_routes.php');

        /* $this->expec */
    }
}
