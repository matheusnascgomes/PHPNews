<?php
use PHPNews\Core\{ ServerResponse, ServerResponseException };

$app = new Slim\Slim();
$app->config('debug', true);

$arrModulesRouters = ['News', 'User', 'Subscribers'];

foreach ($arrModulesRouters as $strModule) {
    require_once $strModule.'/routes.php';
}

$app->run();
