<?php namespace calebdre\Room\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model{
    public $timestamps = false;
    protected $fillable = ['song_id', "user_id"];

    public function voter(){
        return $this->belongsTo("calebdre\\Room\\Models\\User");
    }

    public function song(){
        return $this->belongsTo("calebdre\\Room\\Models\\Song");
    }
}