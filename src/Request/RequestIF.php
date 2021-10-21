<?php


namespace App\GatewayLib\Request;


use Carbon\Carbon;

interface RequestIF
{
    /**
     * url取得
     *
     * @return string
     */
    public function getUrl() : string;

    /**
     * curlオプション配列取得
     *
     * @return array
     */
    public function getCurlOptions() : array;

    /**
     * 送信時間設定
     *
     * @param Carbon $time
     */
    public function setSentTime(Carbon $time) : void;

    /**
     * 送信時間取得
     *
     * @return Carbon
     */
    public function getSentTime() : Carbon;
}
