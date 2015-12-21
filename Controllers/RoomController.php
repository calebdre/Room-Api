<?php namespace calebdre\Room\Controllers;

use calebdre\ApiSugar\ApiController;

class RoomController extends ApiController{
    public $mappings = [
        "crud" => [
            "model" => "calebdre\\Room\\Models\\Room",
            "resource_name" => "rooms"
        ]
    ];
}