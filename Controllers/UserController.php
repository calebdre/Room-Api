<?php namespace calebdre\Room\Controllers;

use calebdre\ApiSugar\ApiController;
use calebdre\Room\Models\User;
use Flight;

class UserController extends ApiController{
    public $mappings = [
        "all" => [
            "method" => "get",
            "route" => "/users"
        ],
        "login" =>[
            "method" => "post",
            "route" => "/users/login"
        ],
        "register" => [
            "method" => "post",
            "route" => "/users/register"
        ]
    ];

    public function all(){
        Flight::json(User::all());
    }

    public function login(){
        $data = Flight::request()->data->getData();
        if($this->checkAgainstRequestParams(['email', 'password']) !== true){
            $this->error("Please supply both an email and password");
            return;
        }

        $fetch = User::where("email", "=", $data['email']);
        if($fetch->count() == 0){
            $this->error("User not found");
            return;
        }

        $user = $fetch->first();
        
        if(password_verify($data['password'], $user->password)){
            $this->success();
        }else{
            $this->fail();
        }
    }

    public function register(){
        $data = Flight::request()->data->getData();

        if($this->checkAgainstRequestParams(['email', "username", 'password']) !== true){
            $this->error("Please supply both an email and password and username");
            return;
        }

        $user = new User($data);
        $user->password = password_hash($data["password"], PASSWORD_DEFAULT);

        if($user->save()){
            $this->success();
        }else{
            $this->fail();
        }

    }
}