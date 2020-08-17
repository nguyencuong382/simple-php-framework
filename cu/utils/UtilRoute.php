<?php

namespace Cu\Utils;

use Cu\Http\Response;
use Cu\Utils\IUtilRoute;

class UtilRoute implements IUtilRoute
{

    private $exts = ['js', 'css'];

    public function mapUrl($pattern, $url)
    {
        $pattern_arr = explode('/', $pattern);
        $url_arr = explode('/', $url);

        if (count($pattern_arr) !== count($url_arr)) {
            return null;
        }

        // print_r($pattern_arr);
        // print_r($url_arr);

        $params = array();
        foreach ($pattern_arr as $key => $sub_pattern) {
            if (preg_match('({.+})', $sub_pattern)) {
                $params[$key] = $url_arr[$key];
            } else {
                if ($sub_pattern !== $url_arr[$key]) {
                    return null;
                }
            }

        }

        return $params;
    }

    public function resolveError($status_code, $error = null)
    {
        $res = new Response();
        $res->response($status_code, $error);
    }

    public function resovlveMedia($url)
    {
        $ext = substr($url, strrpos($url, '.') + 1);

        if (in_array($ext, $this->exts)) {

            switch ($ext) {
                case 'js':
                    header('Content-Type: text/javascript');
                    echo file_get_contents(__DIR__ . './../../app/public/js/' . substr($url, strrpos($url, '/') + 1));
                    break;
                case 'css':
                    header('Content-Type: text/css');
                    echo file_get_contents(__DIR__ . './../../app/public/css/' . substr($url, strrpos($url, '/') + 1));
                    break;
                default:
                    # code...
                    break;
            }

            return true;
        }

        return false;
    }

    public function retreiveGetParams(&$url)
    {
        $params = array();
        if (strpos($url, '&') <= 0) {
            return $params;
        }

        $exploded_url = explode('&', $url);
        $url = array_shift($exploded_url);
        foreach ($exploded_url as $key => $value) {
            $mapping_params = explode('=', $value);
            if (count($mapping_params) != 2) {
                return $params;
            } else {
              list($paramName, $paramValue) = $mapping_params;

              $params[$paramName] = str_replace('%20', ' ', $paramValue);
            }
        }
        return $params;
    }
}
