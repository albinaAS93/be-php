<?php

    include_once 'core/Router.php';
    include_once 'core/Request.php';
    $routes = include_once 'routes.php';

    $request = new Request;
    $request->decodeHttpRequest();

    if ($request->getMethod() === 'OPTIONS') {

        header("Access-Control-Allow-Origin: *");
    
        header("Content-Type: application/json; charset=UTF-8");
    
        header("Access-Control-Allow-Methods: DELETE, PUT, GET, POST");
    
        header("Access-Control-Max-Age: 3600");
    
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
        http_response_code(200);
    
        exit;
    }

    $fileContent = file(__DIR__.'/.env');
    foreach($fileContent as $envVar){
        putenv(trim($envVar));} 

    $router = new Router;
    $router->load($routes);

    $router->direct($request->getPath(), $request->getMethod());