<?php


$route->get('/api/search/people', 'search\SearchController@getPeopByName');
$route->get('/api/search/user', 'search\SearchController@getLabelPeople');