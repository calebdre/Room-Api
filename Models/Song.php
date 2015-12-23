<?php namespace calebdre\Room\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model{
    public $timestamps = false;
    protected $fillable = ["name", "author", "url", "thumbnail_url", "user_id", "songs_queue_id"];

    public function suggester(){
        return $this->belongsTo("calebdre\\Room\\Models\\User");
    }

    public function queue(){
        return $this->belongsTo("calebdre\\Room\\Models\\SongQueue");
    }

    public function votes(){
        return $this->hasMany("calebdre\\Room\\Models\\Vote");
    }
}