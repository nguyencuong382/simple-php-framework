<?php

namespace App\Controller;

use Cu\Controller\Controller;

class HomeController extends Controller
{

    public function index($req, $res)
    {
        $res->contentType = 'text/html';
        try {
            $res->render('index.php');
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function add($req, $res)
    {
        $res->contentType = 'text/html';
        try {
            $res->render('add.php');
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
