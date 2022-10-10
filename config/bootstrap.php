<?php
use DI\Container;
use DI\Bridge\Slim\Bridge as SlimAppFactory;

require_once __DIR__  .'/../vendor/autoload.php';

$container = new Container();

$dotenv =  Dotenv\Dotenv::createImmutable(__DIR__.'/..');
$dotenv->load();

$settings = require_once __DIR__.'/settings.php';

$settings($container);

$app = SlimAppFactory::create($container);

$middleware = require_once __DIR__ . '/middleware.php';

$middleware($app);

$routes = require_once  __DIR__ .'/routes.php';

$routes($app);

$faker = require_once  __DIR__  . '/../vendor/fzaninotto/Faker/src/autoload.php';

$app->run();