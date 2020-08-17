<?php

$route->get('/api/user', 'ApiPersonController@getAll');

$route->post('/api/user/check', 'ApiPersonController@getUserByData');

$route->post('/api/user', 'ApiPersonController@addPerson');

$route->put('/api/user/{id}','ApiPersonController@updatePerson');

$route->delete('/api/user/{id}', 'ApiPersonController@deltePerson');
