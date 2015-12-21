<?php namespace calebdre\Room\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model{

    public function suggester(){
        return $this->belongsTo("calebdre\\Room\\Models\\User");
    }

    public function room(){
        return $this->belongsTo("calebdre\\Room\\Models\\Room");
    }
}