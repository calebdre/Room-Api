<?php

include "vendor/autoload.php";

use \calebdre\ApiSugar\Api;
use calebdre\Room\Controllers\RoomController;
use calebdre\Room\Controllers\UserController;

$api = new Api();

$api->configureDB([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'room',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$api->addClass(new RoomController());
$api->addClass(new UserController());
$api->execute();