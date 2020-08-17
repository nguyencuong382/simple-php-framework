<?php

namespace Cu\Route;

abstract class ARoute
{
    protected $utilRoute;

    public function __construct($utilRoute) {
      $this->utilRoute = $utilRoute;
    }

    abstract function __call($name, $args);

    abstract function resolve();

    public function __destruct()
    {
        $this->resolve();
    }
}
