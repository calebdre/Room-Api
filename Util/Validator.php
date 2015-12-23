<?php namespace calebdre\Room\Util;

class Validator{
    public static function validateEmail($email){
        return !filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}