<?php

namespace Norival\Phable\tests;

use Norival\Phable\Controller\AbstractController;

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
