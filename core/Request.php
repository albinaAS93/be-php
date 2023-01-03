<?php

class Request {
    
    protected $method;
    protected $path;
    protected $body;

    function getMethod()
    {
        return $this->method;
    }

    function getPath()
    {
        return $this->path;
    }

    function getBody()
    {
        return $this->body;
    }

    function decodeHttpRequest()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->path = trim($_SERVER['REQUEST_URI'], '/');
        $this->body = json_decode(file_get_contents('php://input'), true);
    }
}