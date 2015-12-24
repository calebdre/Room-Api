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
            "eager_relations" => ['queue.songs', "host", "users"],
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
            "route" => "/rooms/user"
        ],
        "removeUserFromRoom" => [
            "method" => "delete",
            "route" => "/rooms/user"
        ]
    ];

    public function songs($id){
        Flight::json(Room::find($id)->queue->songs->toArray());
    }

    public function create(){
        $data = $this->getRequestData();

        $this->findModelOrFail(new User(), $data['user_id'], "user");

        $resource = Room::create($data);
        SongQueue::create(['room_id' => $resource->id]);

        $this->success("", ["room" => $resource->toArray()]);
    }

    public function addUserToRoom(){
        $this->checkAgainstRequestParams(['room_id', 'user_id']);

        $data = $this->getRequestData();

        $room = $this->findModelOrFail(new Room(), $data['room_id'], "room");
        $user = $this->findModelOrFail(new User(), $data['user_id'], "user");

        if($room->users()->save($user)){
            $room->load("user");
            $this->success("", ['room' => $room->toArray()]);
        }else{
            $this->fail("Could not add the user to the room.");
        }
    }

    public function removeUserFromRoom(){
        $this->checkAgainstRequestParams(['room_id', 'user_id']);
        $data = $this->getRequestData();

        $room = $this->findModelOrFail(new Room(), $data['room_id'], "room");
        $user = $this->findModelOrFail(new User(), $data['user_id'], "user");

        $room->users()->detach($user->id);
        $this->success();
    }
}