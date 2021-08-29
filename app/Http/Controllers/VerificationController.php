<?php


namespace App\Http\Controllers;

class VerificationController extends Controller
{

    public function request() {

        $username = request("username");
        app('redis')->set($username, random_int(10000, 99999));

        // verification code is valid for 2 minutes
        app('redis')->expire($username, 60 * 3);


        return $username;
    }

    public function getVerificationCode() {
        return ['code' => app('redis')->get(request('username'))];
    }

    public function checkVerificationCode() {
        return ["isValid" => app('redis')->get(request('username')) === request('code')];
    }

}
