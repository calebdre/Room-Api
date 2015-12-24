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
            "eager_relations" => ["suggester", "room", "votes"],
        ],
        "vote" => [
            "method" => "post",
            "route" => "/songs/vote"
        ]
    ];

    public function vote(){
        $data = $this->getRequestData();

        $this->checkAgainstRequestParams(['user_id', 'song_id']);
        $this->findModelOrFail(new User(), $data['user_id'], "user");

        $vote = Vote::create($data);
        $this->success("", ['vote' => $vote->toArray()]);
    }
}