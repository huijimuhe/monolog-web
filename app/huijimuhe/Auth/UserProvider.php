<?php

namespace huijimuhe\Auth;

use Account,
    huijimuhe\Support\Easemob;

class UserProvider {

    public function __construct() {
        
    }

    public function storeUser($credentials) {
        $user = new Account();
        $user->fill($credentials)->save();
        return $user;
    }

    public function updateToken($user, $token) {
        return $user->update(['app_token' => $token]);
    }

    public function cleanToken($user) {
        return $user->update(['app_token' => '']);
    }

    public function storeEaseMob($user) {
        $ee = new Easemob();
        $opt['username'] = $user->id;
        $opt['password'] = 'pwd' . $user->id;
        $opt['nickname'] = $user->name;
        return $ee->accreditRegister($opt);
    } 
}
