<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT');

require_once '../vendor/autoload.php';
require_once '../config/'.$_SERVER['HTTP_HOST'].'.conf.php';
require_once '../src/AppPHPNews/routes.php';