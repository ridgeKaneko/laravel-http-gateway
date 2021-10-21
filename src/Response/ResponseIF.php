<?php


namespace App\GatewayLib\Response;


use App\GatewayLib\Dto\ResponseContext;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

interface ResponseIF
{
    /**
     * レスポンス本文の内容を自身のオブジェクトに取り込み
     * @param ResponseContext $context
     */
    public function __construct(ResponseContext $context);

    /**
     * レスポンス取得時間取得
     *
     * @return Carbon
     */
    public function receivedTime() : Carbon;

    /**
     * タイムアウト判定
     *
     * @return bool
     */
    public function isTimeout() : bool;

    /**
     * httpステータス取得
     *
     * @return int
     */
    public function httpStatus() : int;

    /**
     * レスポンス妥当性検証
     *
     * @throws ValidationException
     */
    public function validate() : void;

    /**
     * レスポンス妥当性検証
     *
     * @return bool valid:false invalid:true
     */
    public function fails() : bool;
}
