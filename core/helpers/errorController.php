<?php
namespace core\helpers;

class errorController
{
    public function __construct(){}

    public function show404()
    {
        header('HTTP/1.0 404 Not Found');
    }
}