<?php


namespace App\GatewayLib;


class Util
{
    /**
     * 連想配列判定
     *
     * @param array $arr
     * @return bool
     */
    public static function isMap(array $arr)
    {
        return array_values($arr) !== $arr;
    }

    /**
     * 配列（添え字連番）判定
     *
     * @param array $arr
     * @return bool
     */
    public static function isArr(array $arr)
    {
        return array_values($arr) === $arr;
    }
}