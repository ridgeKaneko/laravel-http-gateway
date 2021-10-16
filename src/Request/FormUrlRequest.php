<?php


namespace App\GatewayLib\Request;


abstract class FormUrlRequest extends Request
{
    protected static function encodePostFields(array $fields)
    {
        return http_build_query($fields);
    }
}
