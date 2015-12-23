<?php namespace calebdre\Room\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model{
    public $timestamps = false;
    protected $fillable = ["name", "user_id", "harman_speakers_enabled", "enter_code"];

    public function creator(){
        return $this->belongsTo("calebdre\\Room\\Models\\User");
    }

    public function users(){
        return $this->hasMany("calebdre\\Room\\Models\\User", "users_in_room", "room_id", "user_id");
    }

    public function songs(){
        return $this->hasMany("calebdre\\Room\\Models\\Song");
    }
}