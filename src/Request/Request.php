<?php


namespace App\GatewayLib\Request;


use Carbon\Carbon;

abstract class Request implements RequestIF
{
    private $__url = '';
    private $__method = 'GET';
    private $__headers = [];
    private $__timeout = 0;
    private $__sentTime;

    protected function url()
    {
        return $this->__url;
    }

    protected function method()
    {
        return $this->__method;
    }

    protected function headers()
    {
        return $this->__headers;
    }

    protected function timeoutMs()
    {
        return $this->__timeout;
    }

    protected static function encodePostFields(array $fields)
    {
        return $fields;
    }

    private function getPostFields()
    {
        $vars = get_class_vars(static::class);
        $fields = [];

        foreach ($vars as $key => $value) {
            $fields[$key] = $this->$key;
        }

        return $fields;
    }

    final public function getUrl(): string
    {
        return $this->url();
    }

    final public function getCurlOptions(): array
    {
        return [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $this->headers(),
            CURLOPT_POSTFIELDS => static::encodePostFields($this->getPostFields()),
            CURLOPT_CONNECTTIMEOUT_MS => $this->timeoutMs(),
            CURLOPT_CUSTOMREQUEST => $this->method()
        ];
    }

    final public function setSentTime(Carbon $time): void
    {
        $this->__sentTime = $time;
    }

    final public function getSentTime(): Carbon
    {
        return $this->__sentTime;
    }

    final public function setUrl($url)
    {
        $this->__url = $url;

        return $this;
    }

    final public function setMethod($method)
    {
        $this->__method = $method;

        return $this;
    }

    final public function setHeaders($headers)
    {
        $this->__headers = $headers;

        return $this;
    }

    final public function setTimeoutMs($timeout)
    {
        $this->__timeout = $timeout;

        return $this;
    }

}
