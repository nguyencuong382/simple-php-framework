<?php

   function __autoload($className) {
      $fileName = __DIR__ .'\\'. $className .".php";
      // echo $fileName;
      include_once($fileName);
    }


// foreach (glob("app/*.php") as $filename)
// {
//     echo $filename;
//     include $filename;
// }

// function load($className) {
//   $className = str_replace("\\", '/', $className);     
//   $fileName = "./". $className .".php";
//   echo $fileName;
//   include_once($fileName);
// }

// spl_autoload_register(__NAMESPACE__.'\load', true, true);  

// include_once __DIR__.'./app/index.php';
include_once __DIR__.'./app/routes/_index.php';
?>