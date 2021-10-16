<?php


namespace App\GatewayLib\Response;


abstract class JsonResponse extends Response
{
    public $params = [];

    static protected function decodeContentBody(string $contentBody): array
    {
        return json_decode($contentBody,true) ?? [];
    }
}
