<?php


namespace App\GatewayLib\Response;


use App\GatewayLib\Dto\ResponseContext;
use App\GatewayLib\Util;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use stdClass;

abstract class Response implements ResponseIF
{
    /**
     * validationルール定義定数
     */
    protected const RULES = [];

    private $__params = [];

    private $__context;

    /**
     * @var \Illuminate\Contracts\Validation\Validator
     */
    private $__validator;

    final public function __construct(ResponseContext $context)
    {
        $this->__context = $context;
        $this->__params = static::decodeContentBody($context->body);

        $this->__validator = Validator::make($this->__params,static::RULES);

        foreach ($this->__params as $key => $item) {
            $this->$key = $this->parseItem($item);
        }
    }

    /**
     * 連想配列解析
     *
     * @param array $map
     * @return stdClass
     */
    private function parseMap(array $map)
    {
        $obj = new stdClass();

        foreach ($map as $key => $item)
        {
            $obj->$key = $this->parseItem($item);
        }

        return $obj;
    }

    /**
     * 配列解析
     *
     * @param array $arr
     * @return array
     */
    private function parseArray(array $arr)
    {
        return collect($arr)->map(function ($item) {
            return $this->parseItem($item);
        })->toArray();
    }

    /**
     * 項目値解析
     *
     * @param $item
     * @return array|stdClass
     */
    private function parseItem($item)
    {
        if (is_array($item))
        {
            if (Util::isMap($item)) {
                return $this->parseMap($item);
            }
            else {
                return $this->parseArray($item);
            }
        }
        else {
            return $item;
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
        return $this->__context->isTimeout;
    }

    final public function httpStatus(): int
    {
        return $this->__context->httpStatus;
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
        return $this->__context->receivedTime;
    }
}
