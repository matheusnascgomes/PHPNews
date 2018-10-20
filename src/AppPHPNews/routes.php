<?php

$app = new Slim\Slim();
$app->config('debug', true);

$arrModulesRouters = ['News', 'User'];

foreach ($arrModulesRouters as $strModule)
    require_once $strModule.'/routes.php';

$app->run();
