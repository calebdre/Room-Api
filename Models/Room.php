<?php namespace calebdre\Room\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model{
    public $timestamps = false;

    public function creator(){
        return $this->belongsTo("calebdre\\Room\\Models\\User");
    }

    public function users(){
        return $this->hasMany("calebdre\\Room\\Models\\User", "users_in_room", "room_id", "user_id");
    }
}