<?php

//ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';
require '../webmech.config.php';

$app = new \Slim\Slim(array('debug' => true));
$response = $app->response();
$response['Content-Type'] = 'application/json';

$corsOptions = [
  'origin'        => '*',
  'exposeHeaders' => ['Content-Type', 'X-WEBMECHANIX-APIKEY', 'X-Requested-With', 'X-Authentication', 'X-Client'],
  'allowMethods'  => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS']
];

$cors = new \CorsSlim\CorsSlim($corsOptions);
$app->add($cors);

$app->conf = $config;

foreach ( glob('services/*.php' ) as $filename ) require_once $filename;

$app->run();
