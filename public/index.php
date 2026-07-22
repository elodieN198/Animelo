<?php

require __DIR__ . '/../Autoloader.php';

use App\Autoloader;
use App\Core\Router;

Autoloader::register();

$router = new Router();
$router->run();