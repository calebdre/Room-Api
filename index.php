<?php

include "vendor/autoload.php";

use \calebdre\ApiSugar\Api;
use calebdre\Room\Controllers\RoomCommunicationController;
use calebdre\Room\Controllers\RoomController;
use calebdre\Room\Controllers\SongsController;
use calebdre\Room\Controllers\UserController;
use Ratchet\Server\IoServer;

$api = new Api();

$api->configureDB(include("dbConfig.php"));

$api->addClass(new RoomController());
$api->addClass(new UserController());
$api->addClass(new SongsController());
$api->execute();