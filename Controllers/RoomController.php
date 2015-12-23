<?php namespace calebdre\Room\Controllers;

use calebdre\ApiSugar\ApiController;
use calebdre\Room\Models\Room;
use calebdre\Room\Models\SongQueue;
use calebdre\Room\Models\User;
use Flight;

class RoomController extends ApiController{
    public $mappings = [
        "crud" => [
            "model" => "calebdre\\Room\\Models\\Room",
            "resource_name" => "rooms",
            "eager_relations" => ['queue.songs', "host"],
            "not" => ["create"]
        ],
        "songs" =>[
            "method" => "get",
            "route" => "/rooms/@id:\\d+/songs"
        ],
        "create" => [
            "method" => "post",
            "route" => "/rooms"
        ]
    ];

    public function songs($id){
        Flight::json(Room::find($id)->queue->songs()->toArray());
    }

    public function create(){
        $data = Flight::request()->data->getData();

        if(is_null(User::find($data['user_id']))){
            $this->fail("could not find the user.");
            return;
        }

        $resource = Room::create($data);
        SongQueue::create(['room_id' => $resource->id]);

        $this->success("", ["room" => $resource->toArray()]);
    }
}