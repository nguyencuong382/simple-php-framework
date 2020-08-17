<?php
namespace Cu\Route;

use Cu\Http\Request;
use Cu\Http\Response;
use Cu\Route\ARoute;
// use App\Controller\HomeController;


class UrlToControllerRoute extends ARoute
{
    public function __call($name, $args)
    {
        list($route, $handller) = $args; // form of handler is Controller@methodHandler;
        $this->{strtoupper($name)}[strtolower($route)] = $handller;
    }

    public function resolve()
    {
        $url_api = "/" . (isset($_SERVER['REDIRECT_QUERY_STRING']) ? $_SERVER['REDIRECT_QUERY_STRING'] : "");
        // print_r($_SERVER);

        if ($this->utilRoute->resovlveMedia($url_api)) {
            return;
        }

        if (!isset($this->{$_SERVER['REQUEST_METHOD']})) {
            $this->utilRoute->resolveError(404, ["err" => "No support method " . $_SERVER['REQUEST_METHOD']]);
            return;
        }


        $mapping_apis_arr = $this->{$_SERVER['REQUEST_METHOD']};
        $paramsGet = $this->utilRoute->retreiveGetParams($url_api);

        // echo $url_api;
        // print_r($mapping_apis_arr);

        foreach ($mapping_apis_arr as $url_pattern => $handller) {

            if (($params = $this->utilRoute->mapUrl($url_pattern, $url_api)) !== null) {

                $req = new Request([
                    'data' => file_get_contents("php://input"),
                    'url' => $url_api,
                    'params' => $paramsGet
                ]);

                $res = new Response();
                list($controllerName, $methodName) = explode('@', $handller);
                
                $controllerName = 'App\Controller\\' . $controllerName;

                $classController = new $controllerName();

                if (is_array($params) && count($params) > 0) {
                    $classController->$methodName($req, $res, ...$params);
                } else {
                    $classController->$methodName($req, $res);
                }
                return;
            }
        }

        $this->utilRoute->resolveError(404, ["err" => "No support url " . $url_api, "params" => $this->utilRoute->retreiveGetParams($url_api), "origin url" => $url_api]);
    }

}
