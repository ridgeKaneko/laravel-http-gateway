<?php


namespace App\GatewayLib\Request;


use Carbon\Carbon;

interface RequestIF
{
    public function getUrl() : string;

    public function getCurlOptions() : array;

    public function setSentTime(Carbon $time) : void;

    public function getSentTime() : Carbon;
}
