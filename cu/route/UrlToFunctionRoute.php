<?php

namespace Cu\Route;

use Cu\Route\ARoute;
use Cu\Http\Request;
use Cu\Http\Response;

class UrlToFunctionRoute extends ARoute
{
    public function __call($name, $args)
    {
        list($route, $func) = $args;
        $this->{strtoupper($name)}[strtolower($route)] = $func;
    }

    public function resolve()
    {
        $url_api = "/" . (isset($_SERVER['REDIRECT_QUERY_STRING']) ? $_SERVER['REDIRECT_QUERY_STRING'] : "");
        // print_r($_SERVER);

        if($this->utilRoute->resovlveMedia($url_api)) {
          return ;
        }

        if (!isset($this->{$_SERVER['REQUEST_METHOD']})) {
            $this->utilRoute->resolveError(404);
            return;
        }

        $mapping_apis_arr = $this->{$_SERVER['REQUEST_METHOD']};

        // echo $url_api;
        // print_r($mapping_apis_arr);

        foreach ($mapping_apis_arr as $url_pattern => $func) {
            if (($params = $this->utilRoute->mapUrl($url_pattern, $url_api)) !== null) {

                $req = new Request([
                  'data' => file_get_contents("php://input"),
                  'url' => $url_api
                ]);
                
                $res = new Response();
                if (is_array($params) && count($params) > 0) {
                    $func($req, $res, ...$params);
                } else {
                    $func($req, $res);
                }
                return;
            }
        }

        $this->utilRoute->resolveError(500);
    }
    
}
