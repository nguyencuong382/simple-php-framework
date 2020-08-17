<?php

namespace Cu\Http;

use Cu\Http\IResponse;
use Cu\Render\Render;

class Response extends Render implements IResponse
{

    private $props = array();

    public function __construct($contentType = 'application/json')
    {
        $this->props['contentType'] = $contentType;
    }

    public function response($status_code, $data = null)
    {
        header($this->get_http_header_response($status_code));
        header("Content-Type: " . $this->props['contentType']);
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        // print_r($data);
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(["error" => "no data response"]);
        }
        exit;
    }

    public function get_http_header_response($status_code)
    {
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return "HTTP/1.1 " . $status_code . " " . $status[$status_code];
    }

    public function __get($key)
    {
        return $this->props[$key];
    }

    public function __set($key, $value)
    {
        $this->props[$key] = $value;
    }

}