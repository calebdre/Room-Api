<?php namespace calebdre\Room\Controllers;

use calebdre\ApiSugar\ApiController;

class UserController extends ApiController{
    public $mappings = [
        "crud" => [
            "model" => "calebdre\\Room\\Models\\User",
            "resource_name" => "users"
        ]
    ];
}