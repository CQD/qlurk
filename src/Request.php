<?php
namespace Qlurk;

/**
 * Class Request
 *
 * This is used to pack all request related property into one object.
 *
 * @package Qlurk
 */
class Request
{
    public $method;
    public $path;
    public $params = [];
    public $headers = [];

    public function __construct($method, $path, $params = [], $headers = [])
    {
        $method = strtoupper($method);
        if ('POST' === $method) {
            $this->headers['Content-Type'] = 'application/x-www-form-urlencoded';
        }

        $this->method = $method;
        $this->path = $path;
        $this->params = array_merge($this->params, $params);
        $this->headers = array_merge($this->headers, $headers);
    }
}