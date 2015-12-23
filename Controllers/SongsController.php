<?php namespace calebdre\Room\Controllers;
use calebdre\ApiSugar\ApiController;

class SongsController extends ApiController{
    public $mappings = [
        "crud" => [
            "model" => "calebdre\\Room\\Models\\Song",
            "resource_name" => "songs",
            "eager_relations" => "suggester, queue.room"
        ]
    ];
}