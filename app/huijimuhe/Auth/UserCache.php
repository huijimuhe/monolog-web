<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace huijimuhe\Auth;

use Account,
    Carbon,
    Cache,
    Hash;

class UserCache {

    public function attempt($token) {

        if (is_null($token)) {
            return false;
        }

        if (!Cache::has($token)) {
            //cache没有这个token，有可能是过期了，数据库查一遍 
            $user = Account::where('app_token', '=', $token)->first();
            if (!is_null($user)) {
                //数据库有这个token，说明过期了 
                //cache添加token,这里做成永不过期那种感觉了..除非再次登录，否则不在更新token
                //用户登录过期，可以用登录时间戳来扩展检查
                $expiresAt = Carbon::now()->addDays(30);
                Cache::put($token, $user, $expiresAt);
                return true;
            } else {
                //数据库没有这个token，说明验证出错  
                return false;
            }
        } else {
            return true;
        }
    }

    public function retrieveByToken($token) {
        return Cache::get($token);
    }

    public function updateToken($user) {
        //DB更新token
        $token = Hash::make($user->salt . Carbon::now());
        //cache保存新的token
        $expiresAt = Carbon::now()->addDays(30);
        Cache::put($token, $user, $expiresAt);
        //返回token
        return $token;
    }

    public function cleanToken($token) {
        if (Cache::has($token)) {
            Cache::forget($token);
        }
    }

}
