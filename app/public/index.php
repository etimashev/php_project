<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Utility\EnvLoader;
use Utility\Handler;
use Utility\Logger;
use Utility\Router;

EnvLoader::init();
Handler::init();
Logger::init();

Router::init(
    method: $_SERVER['REQUEST_METHOD'],
    uri: strtok($_SERVER["REQUEST_URI"], '?'),
    request: $_REQUEST,
);
