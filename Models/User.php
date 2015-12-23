<?php namespace calebdre\Room\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model{
    protected $fillable = ['email', 'username', 'password'];
    public $timestamps = false;
    protected $hidden = ["password"];

    public function suggestedSongs(){
        return $this->hasMany("calebdre\\Room\\Models\\Song");
    }

    public function room(){
        return $this->hasOne("calebdre\\Room\\Models\\Room");
    }
}