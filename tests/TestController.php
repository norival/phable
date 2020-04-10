<?php

namespace Norival\Spine\tests;

use Norival\Spine\Core\AbstractController;

class TestController extends AbstractController
{
    public function testNoSlug(): string
    {
        return 'ok';
    }

    public function testSlug($param): string
    {
        return $param['slug'];
    }
}
