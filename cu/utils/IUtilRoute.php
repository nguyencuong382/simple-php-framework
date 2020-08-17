<?php

namespace Cu\Utils;

interface IUtilRoute
{
    function mapUrl($pattern, $url);
    public function resolveError($status_code, $error = null);
    public function resovlveMedia($url);
}
