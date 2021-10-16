<?php


namespace App\GatewayLib\tests;


use App\GatewayLib\Request\Request;

class TestRequest extends Request
{
    public $param1;
    public $param2;
    public $param3;

    protected function method()
    {
        return 'POST';
    }

    protected function timeoutMs()
    {
        return 30000;
    }
}
