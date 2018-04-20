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
    public $multipart = [];

    public function __construct($method, $path, $params = [], $headers = [])
    {
        $method = strtoupper($method);
        switch ($path) {
        case '/APP/Timeline/uploadPicture':
        case '/APP/Users/updateAvatar':
            foreach ($params as $key => $value) {
                $this->multipart[$key] = $value;
            }
            break;
        default:
            $this->params = $params;
        }

        $this->method = $method;
        $this->path = $path;
        $this->headers = $headers;
    }
}