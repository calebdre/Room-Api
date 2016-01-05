<?php namespace calebdre\Room\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model{
    public $timestamps = false;
    protected $hidden = ["user_id"];
    protected $fillable = ["name", "user_id", "using_harman_speakers", "enter_code"];

    public function host(){
        return $this->belongsTo("calebdre\\Room\\Models\\User", "user_id");
    }

    public function users(){
        return $this->belongsToMany("calebdre\\Room\\Models\\User", "users_in_room", "room_id", "user_id");
    }

    public function songs(){
        return $this->hasMany("calebdre\\Room\\Models\\Song");
    }
}
