<?php namespace calebdre\Room\Models;
use Illuminate\Database\Eloquent\Model;

class SongQueue extends Model{
    public $timestamps = false;
    public $table = "songs_queue";
    protected $fillable = ['room_id'];

    public function songs(){
        return $this->hasMany("calebdre\\Room\\Models\\Song", "songs_queue_id");
    }

    public function room(){
        return $this->belongsTo("calebdre\\Room\\Models\\Room");
    }
}