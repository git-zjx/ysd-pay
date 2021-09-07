<?php

namespace Git_zjx\Pay\Tests\Gateways;

use Git_zjx\Pay\Pay;
use Git_zjx\Pay\Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class AlipayTest extends TestCase
{
    public function testSuccess()
    {
        $success = Pay::alipay([])->success();

        $this->assertInstanceOf(Response::class, $success);
        $this->assertEquals('success', $success->getContent());
    }
}
