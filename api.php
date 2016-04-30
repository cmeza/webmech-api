<?php

require 'vendor/autoload.php';
require '../webmech.config.php';

$app = new \Slim\Slim(array('debug' => true));
$res = $app->response();
$res['Content-Type'] = 'application/json';

$app->conf = $config;

foreach ( glob('services/*.php' ) as $filename ) require_once $filename;

$app->run();
