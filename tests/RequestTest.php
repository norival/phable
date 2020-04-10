<?php

namespace Norival\Spine\tests;

use Norival\Spine\Core\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testCanBeInitializedGet()
    {
        $server = [
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/test/page',
            'QUERY_STRING'   => 'var1=42&var2=12&var3=toto',
        ];

        $request = new Request();
        $request->initialize($server);

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/test/page', $request->getUri());
        $this->assertEmpty($request->getBody());
        $this->assertCount(3, $request->getParameters());
        $this->assertArrayHasKey('var1', $request->getParameters());
        $this->assertArrayHasKey('var2', $request->getParameters());
        $this->assertArrayHasKey('var3', $request->getParameters());
        $this->assertEquals('toto', $request->getParameters()['var3']);
    }

    public function testCanBeInitializedPost()
    {
        $server = [
            'REQUEST_METHOD' => 'POST',
            'REQUEST_URI'    => '/test/page',
        ];
        $post = [
            'var1' => 42,
            'var2' => 12,
            'var3' => 'toto',
        ];

        $request = new Request();
        $request->initialize($server, $post);

        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/test/page', $request->getUri());
        $this->assertEmpty($request->getParameters());
        $this->assertArrayHasKey('var1', $request->getBody());
        $this->assertArrayHasKey('var2', $request->getBody());
        $this->assertArrayHasKey('var3', $request->getBody());
        $this->assertEquals('toto', $request->getBody()['var3']);
    }
}
