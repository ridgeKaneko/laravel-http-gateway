<?php


namespace App\GatewayLib\Dto;


class ResponseContext
{
    public $body;
    public $isTimeout;
    public $httpStatus;
    public $curlErrNo;
    public $receivedTime;
}