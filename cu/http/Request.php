<?php

namespace Cu\Http;

use Cu\Http\IRequest;

class Request implements IRequest
{
    private $props;

    public function __construct($dataInit = [])
    {
        $this->props = $dataInit;
    }

    public function getData()
    {
        return json_decode($this->props['data'], true);
    }

    public function __set($key, $value)
    {
      $this->props['$key'] = $value;
    }

    public function __get($key)
    {
      return $this->props[$key];
    }

}
