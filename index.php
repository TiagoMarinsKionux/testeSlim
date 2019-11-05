<?php

require 'vendor/autoload.php';

$app = new Slim\App();
$app->get('/', function($request, $response, $artgs){
    echo 'teste';
});
$app->run();