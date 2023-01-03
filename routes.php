<?php

return $routes = [

    'GET' => [
        'cities' => 'CitiesController@read',
        'users' => 'UsersController@read',
        'flights' => 'FlightsController@read',
    ],
    'POST' => [
        'cities' => 'CitiesController@create',
        'flights' => 'FlightsController@create',
        'users' => 'UsersController@create',
        'login' => 'UsersController@login',
    ],
    'PUT' => [
        'cities' => 'CitiesController@update',
        'flights' => 'FlightsController@update',
    ],
    'DELETE' => [
        'cities' => 'CitiesController@delete',
        'flights\/(\d+)' => 'FlightsController@delete',
    ]
];