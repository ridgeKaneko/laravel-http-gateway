<?php


namespace App\GatewayLib;


use App\GatewayLib\Dto\ResponseContext;
use App\GatewayLib\Events\AfterReceiveResponse;
use App\GatewayLib\Events\BeforeSendRequest;
use App\GatewayLib\Exception\HttpGatewayException;
use App\GatewayLib\Request\RequestIF;
use App\GatewayLib\Response\ResponseIF;
use Carbon\Carbon;

class HttpGateway
{
    /**
     * リクエスト送信
     *
     * @param RequestIF $request
     * @param string $resModelClass
     * @return ResponseIF
     * @throws HttpGatewayException
     */
    public static function request(RequestIF $request,string $resModelClass)
    {
        if (!is_subclass_of($resModelClass,ResponseIF::class)) {
            throw new HttpGatewayException('resModelClassはResponseIFを実装したクラスである必要があります。');
        }

        //curl設定
        $curl = curl_init($request->getUrl());
        curl_setopt_array($curl,$request->getCurlOptions());

        $request->setSentTime(Carbon::now());
        event(new BeforeSendRequest($request));

        //リクエスト送信
        $resBody = curl_exec($curl) ?: null;

        $resCtx = new ResponseContext();
        $resCtx->body = $resBody;
        $resCtx->isTimeout = self::isTimeOut($curl);
        $resCtx->httpStatus = self::getHttpStatus($curl);
        $resCtx->curlErrNo = curl_errno($curl);
        $resCtx->receivedTime = Carbon::now();

        //レスポンスモデル作成
        $response = new $resModelClass($resCtx);
        event(new AfterReceiveResponse($request,$response));

        return $response;
    }

    /**
     * curlリソースの　タイムアウト判定
     *
     * @param resource $curl
     * @return bool
     */
    protected static function isTimeOut($curl)
    {
        $errno = curl_errno($curl);

        return ($errno == CURLE_OPERATION_TIMEDOUT || $errno == CURLE_COULDNT_CONNECT);
    }

    protected static function getHttpStatus($curl)
    {
        return curl_getinfo($curl,CURLINFO_RESPONSE_CODE);
    }
}
