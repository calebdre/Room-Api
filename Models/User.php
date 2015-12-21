<?php namespace calebdre\Room\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model{

    public function suggestedSongs(){
        return $this->hasMany("calebdre\\Room\\Models\\Song");
    }
}