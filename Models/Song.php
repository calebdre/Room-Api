<?php namespace calebdre\Room\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model{
    public $timestamps = false;
    protected $fillable = ["name", "author", "url", "thumbnail_url", "user_id", "room_id"];

    public function suggester(){
        return $this->belongsTo("calebdre\\Room\\Models\\User", "user_id");
    }

    public function room(){
        return $this->belongsTo("calebdre\\Room\\Models\\Room");
    }

    public function votes(){
        return $this->hasMany("calebdre\\Room\\Models\\Vote");
    }

    public function getVotes(){
        return count($this->votes);
    }
}