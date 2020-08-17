<?php
namespace App\Controller;

use Cu\Controller\Controller;
use App\Migration\Migration;

class MigrateController extends Controller
{
    public function migrate($req, $res)
    {
        if (Migration::migrate()) {
            header('Location: ' . './index.php');
        }
    }
}
