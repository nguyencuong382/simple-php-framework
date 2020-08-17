<?php

$route->get('/', 'HomeController@index');
$route->get('/add', 'HomeController@add');
$route->post('/add', 'HomeController@add');
