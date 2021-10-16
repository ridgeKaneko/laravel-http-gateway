<?php

namespace Tests\GatewayLib\tests;

use App\GatewayLib\HttpGateway;
use App\GatewayLib\tests\TestRequest;
use App\GatewayLib\tests\TestResponse;
use PHPUnit\Framework\TestCase;

class HttpGatewayTest extends TestCase
{
    public function testFlow()
    {
        $request = new TestRequest();
        $request->setUrl('https://test.co.jp')
            ->setHeaders(['Content-Type: application/json']);

        $request->param1 = 'value1';
        $request->param2 = 'value2';
        $request->param3 = 'value3';

        $response = HttpGateway::request($request,TestResponse::class);
    }
}
