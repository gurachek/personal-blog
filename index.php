<?php

use Slim\Views\PhpRenderer;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

include_once 'vendor/autoload.php';
include_once 'functions.php';

spl_autoload_register('autoloader');

require_once 'config/main.php';

$user = new models\User();

$app = new \Slim\App($container);

$container = $app->getContainer();
$container['url'] = 'http://localhost:8000/';
$container['template'] = 'layouts/main.php';
$container['renderer'] = new PhpRenderer("views");
$container['userObj'] = $user;
$container['user'] = $user->findUserByAuthKey(@$_COOKIE['auth']);

require_once 'routes/api.php';
require_once 'routes/web.php';

$app->run();