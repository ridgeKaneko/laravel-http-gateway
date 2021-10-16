<?php


namespace App\GatewayLib\Request;


abstract class JsonRequest extends Request
{
    protected static function encodePostFields(array $fields)
    {
        return json_encode($fields);
    }
}
