<?php namespace calebdre\Room\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model{
    public $timestamps = false;
    protected $hidden = ["user_id"];
    protected $fillable = ["name", "user_id", "harman_speakers_enabled", "enter_code"];

    public function host(){
        return $this->belongsTo("calebdre\\Room\\Models\\User", "user_id");
    }

    public function users(){
        return $this->hasMany("calebdre\\Room\\Models\\User", "users_in_room", "room_id", "user_id");
    }

    public function queue(){
        return $this->hasOne("calebdre\\Room\\Models\\SongQueue");
    }
}