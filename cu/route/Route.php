<?php

namespace Cu\Route;

use Cu\Route\UrlMappingRoute;
use Cu\Route\UrlToControllerRoute;
use Cu\Utils\UtilRoute;

class Route extends UrlToControllerRoute
{
    public function __construct()
    {
        $utilRoute = new UtilRoute();
        parent::__construct($utilRoute);
    }
}
