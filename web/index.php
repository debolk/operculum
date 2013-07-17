<?php

require_once '../vendor/autoload.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$app = new Tonic\Application(array(
	'load' => array('../helper/*.php', '../controller/*.php'),
));

ActiveRecord\Config::initialize(function($cfg){
    $cfg->set_model_directory('../models');
    $cfg->set_connections(array(
        'development' => getenv('DB_CONNECTION'),
    ));
});

$request = new Tonic\Request();
$resource = $app->getResource($request);

$response = $resource->exec();

if($response->contentType == 'text/html')
  $response->contentType = 'application/json';
$response->AccessControlAllowOrigin = '*';

$response->output();
