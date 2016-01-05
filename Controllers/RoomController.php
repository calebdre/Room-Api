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
            "eager_relations" => ['songs', "host", "users"],
            "not" => ["create","getRelation"]
        ],
        "songs" =>[
            "method" => "get",
            "route" => "/rooms/@id:\d+/songs"
        ],
        "create" => [
            "method" => "post",
            "route" => "/rooms"
        ],
        "addUserToRoom" => [
            "method" => "post",
            "route" => "/rooms/users"
        ],
        "removeUserFromRoom" => [
            "method" => "delete",
            "route" => "/rooms/users"
        ],
        "removeRoom" => [
            "method" => "delete",
            "route" => "/rooms"
        ]
    ];

    public function songs($id){
        Flight::json(Room::find($id)->songs()->with("votes", "suggester")->get()->toArray());
    }

    public function create(){
        $this->checkAgainstRequestParams(['user_id', "using_harman_speakers", "enter_code", "name"]);
        $data = $this->getRequestData();

        $this->findModelOrFail(new User(), $data['user_id'], "user");
        $resource = Room::create($data);
        $resource->load("host");
        $this->success("", ["room" => $resource->toArray()]);
    }

    public function addUserToRoom(){
        $this->checkAgainstRequestParams(['room_id', 'user_id']);
        $data = $this->getRequestData();

        $room = $this->findModelOrFail(new Room(), $data['room_id'], "room");
        $duplicates = $room->whereHas("users", function($q) use ($data){
            $q->where("user_id", "=", $data['user_id']);
        });

        if($duplicates->count() > 0) {
            $this->fail("This user is already in the room.", ['is_host' => false]);
        }

        if($room->host->id == $data['user_id']){
            $this->fail("Hosts are already in the room", ['is_host' => true]);
        }

        $room->users()->attach($data['user_id']);
        $this->success("", ['room' => $room->toArray(), "is_host" => false]);
    }

    public function removeUserFromRoom(){
        $this->checkAgainstRequestParams(['room_id', 'user_id']);
        $data = $this->getRequestData();

        $room = $this->findModelOrFail(new Room(), $data['room_id'], "room");
        $user = $this->findModelOrFail(new User(), $data['user_id'], "user");

        $room->users()->detach($user->id);
        $this->success("", ["is_host" => $room->user->id == $user->id]);
    }

    public function removeRoom(){
        $this->checkAgainstRequestParams(['id']);
        $data = $this->getRequestData();
        if(Room::find($data['id'])->delete()){
            $this->success();
        }else{
            $this->fail();
        }
    }
}
