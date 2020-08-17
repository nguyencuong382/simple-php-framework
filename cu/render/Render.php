<?php

namespace Cu\Render;

class Render
{
    private $pubicFolder = __DIR__ . './../../app/public/views/';

    public function __construct()
    {
    }
    public function render($view_file_name)
    {
        $path_to_file = $this->pubicFolder . $view_file_name;
        
        if (file_exists($path_to_file)) {
            include_once $path_to_file;
        } else {
            throw new \Exception('No path to file ' . $path_to_file);
        }
    }
}
