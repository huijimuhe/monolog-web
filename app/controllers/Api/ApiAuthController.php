<?php

use huijimuhe\Auth\Guard,
    Illuminate\Support\Facades\Hash;

class ApiAuthController extends BaseController {

    protected $auth;

    public function __construct(Guard $auth) {
        parent::__construct();
        $this->auth = $auth;
    }

    public function postSignout() {
        $this->auth->signOut();
        return Response::make(204, 200);
    }

    public function postSignIn() {

        $salt = md5(\Str::random(64) . time());

        $credentials = [
            'open_id' => Input::get('open_id'),
            'token' => Input::get('token'),
            'name' => Input::get('name'),
            'gender' => Input::get('gender'),
            'avatar' => Input::get('avatar'),
            'isr' => 0,
            'isbanned' => 0,
            'right_count' => 0,
            'miss_count' => 0,
            'statue_count' => 0,
            'fan_count'=>0,
            'poi' => [1, 1], //默认给个
            'password' => Hash::make($salt . Input::get('token'))];

        $validator = Validator::make($credentials, [
                    'open_id' => 'required',
                    'token' => 'required',
                    'name' => 'required|max:20',
                    'gender' => 'required',
                    'avatar' => 'required',
        ]);

        //登录
        $token = $this->auth->attempt($credentials, $validator);

        //验证错误
        if (!$token) {
            return Response::make(400, 200);
        }

        return Response::json(['token' => $token, 'user' => $this->auth->user()]);
    }

    public function getProfile() {
        return Response::json(['profile' => $this->auth->user()]);
    }

    public function postChangeProfile() {
        $profile = [
            'name' => Input::get('name'),
            'gender' => Input::get('gender'),
            'avatar' => Input::get('avatar'),
        ];
        $this->auth->changeProfile($profile);
        return Response::make(209, 200);
    }
 

}
