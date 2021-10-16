<?php


namespace App\GatewayLib\Response;


use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

abstract class Response implements ResponseIF
{
    /**
     * validationルール定義定数
     */
    protected const RULES = [];

    private $__params = [];

    private $__isTimeout;

    private $__httpStatus;

    private $__receivedTime;

    /**
     * @var \Illuminate\Contracts\Validation\Validator
     */
    private $__validator;

    final public function __construct(string $contentBody,bool $isTimeout,int $httpStatus)
    {
        $this->__isTimeout = $isTimeout;
        $this->__httpStatus = $httpStatus;
        $this->params = static::decodeContentBody($contentBody);

        $this->__validator = Validator::make($this->__params,static::RULES);

        foreach ($this->__params as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * レスポンス本文を連想配列にデコード
     *
     * @param string $contentBody
     * @return array
     */
    abstract static protected function decodeContentBody(string $contentBody) : array;

    final public function isTimeout(): bool
    {
        return $this->__isTimeout;
    }

    final public function httpStatus(): int
    {
        return $this->__httpStatus;
    }

    final public function validate(): void
    {
        $this->__validator->validate();
    }

    final public function fails(): bool
    {
        return $this->__validator->fails();
    }

    final public function receivedTime(): Carbon
    {
        return $this->__receivedTime;
    }

    public function setReceivedTime(Carbon $time): void
    {
        $this->__receivedTime = $time;
    }
}
