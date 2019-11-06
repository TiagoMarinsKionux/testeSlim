<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');

require 'vendor/autoload.php';
require 'config/config.php';

$app = new \Slim\App(["settings" => $config]);

$container = $app->getContainer();

$container['db'] = function ($c) {
    $db = $c['settings']['db'];    
    $pdo = new PDO("mysql:host=" . $db['host']. ";dbname=" . 
    $db['dbname'] . ";charset=utf8", $db['user'], $db['pass']);    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);    
    return $pdo;
};
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('testeAPI');
    $file_handler = new \Monolog\Handler\StreamHandler('logs/app.log');
    $logger->pushHandler($file_handler);
    return $logger;
};    


require 'app/routes.php';

$app->run();