<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
require (__DIR__).'/../../vendor/autoload.php';
require (__DIR__).'/../autoload.php';

$setting = require('../settting.php');

$app = new \Slim\App();

$container = $app->getContainer();
$container['setting'] = $setting;

$container['db'] = function($c){

        $db_setting = $c->get('setting')['db'];
        $dsn = 'mysql:host='.$db_setting['host'].';dbname='.$db_setting['dbname'];
        $db_instance = new \PDO($dsn,$db_setting['user'],$db_setting['passwd']);
        return $db_instance;
};

$roters =  glob("../routes/route.*.php");
foreach($roters as $roter)
{
        require $roter;
}
$app->run();

