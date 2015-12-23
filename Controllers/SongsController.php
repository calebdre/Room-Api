<?php namespace calebdre\Room\Controllers;
use calebdre\ApiSugar\ApiController;
use calebdre\Room\Models\User;
use calebdre\Room\Models\Vote;
use Flight;

class SongsController extends ApiController{
    public $mappings = [
        "crud" => [
            "model" => "calebdre\\Room\\Models\\Song",
            "resource_name" => "songs",
            "eager_relations" => ["suggester", "queue.room", "votes"],
        ],
        "vote" => [
            "method" => "post",
            "route" => "/songs/vote"
        ]
    ];

    public function vote(){
        $data = $this->getRequestData();

        if($this->checkAgainstRequestParams(['user_id', 'song_id']) !== true){
            $this->fail("Please pass the user_id and song_id");
            return;
        }
        if(is_null(User::find($data['user_id']))){
            $this->fail("Could not find the user.");
            return;
        }

        $vote = Vote::create($data);
        $this->success("", ['vote' => $vote->toArray()]);
    }
}