<?php namespace calebdre\Room\Controllers;

use calebdre\ApiSugar\ApiController;
use calebdre\Room\Models\User;
use calebdre\Room\Util\Validator;
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
            $this->fail("Please supply both an email and password");
            return;
        }

        $fetch = User::where("email", "=", $data['email']);
        if($fetch->count() == 0){
            $this->fail("User not found");
            return;
        }

        $user = $fetch->first();

        if(password_verify($data['password'], $user->password)){
            $this->success("", ['user' => $user->toArray()]);
        }else{
            $this->fail();
        }
    }

    public function register(){
        $data = Flight::request()->data->getData();

        if($this->checkAgainstRequestParams(['email', "username", 'password']) !== true){
            $this->fail("Please supply both an email and password and username");
            return;
        }

        if(User::where("email", "=", $data['email'])->count() != 0){
            $this->fail("This email has already been registered.");
            return;
        }

        if(User::where("username", "=", $data['username'])->count() != 0){
            $this->fail("This username has already been taken.");
            return;
        }

        if(Validator::validateEmail($data['email'])){
            $this->fail("You entered an invalid email.");
            return;
        }

        $user = new User($data);
        $user->password = password_hash($data["password"], PASSWORD_DEFAULT);

        if($user->save()){
            $this->success("", ["user" => $user->toArray()]);
        }else{
            $this->fail();
        }

    }
}