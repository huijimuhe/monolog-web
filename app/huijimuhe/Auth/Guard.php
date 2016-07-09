<?php

/**
 * //TODO [YOURS]
 * 非常重要！需修改laravel内核以配合salt
 * ------1--------
 * \vendor\laravel\framework\src\Illuminate\Auth\UserTrait.php
 *  public function getSalt() {
      return $this->salt;
    }
 * ------2---------
 * \vendor\laravel\framework\src\Illuminate\Auth\EloquentUserProvider.php
 *   public function validateCredentials(UserInterface $user, array $credentials) {
          $plain = $credentials['password'];
          //这是加了盐的验证模式
          return $this->hasher->check($user->getSalt() . $plain, $user->getAuthPassword());
      }
 */

namespace huijimuhe\Auth;

use Input,
    QiNiu,
    Account,
    Log,
    huijimuhe\Auth\UserProvider,
    huijimuhe\Auth\UserCache;

class Guard {

    protected $provider;
    protected $user;
    protected $cache;

    public function __construct(UserProvider $p, UserCache $c) {
        $this->provider = $p;
        $this->cache = $c;
    }

    /**
     * 获取当前用户
     * @return type
     */
    public function user() {
        $token = Input::get('token');

        if (is_null($token)) {
            return null;
        }

        if (!is_null($this->user)) {
            return $this->user;
        }

        $this->user = null;

        if (!is_null($token) && $this->cache->attempt($token)) {
            $this->user = $this->cache->retrieveByToken($token);
        }
        return $this->user;
    }

    /**
     * 用户验证
     * @return boolean
     */
    public function check() {
        $token = Input::get('token');

        if (is_null($token)) {
            return false;
        }

        $this->user = null;

        return $this->cache->attempt($token);
    }

    /**
     * 用户登录
     * @param type $credentials
     * @return type
     */
    public function attempt($credentials, $validator = null) {
        /*
         * 社交登录
         * 用openID找social中有没有
         * 没有就注册，有就登录
         * 如果需要确保安全，可以后面用类似qiniu上传的安全机制验证
         * 否则只有一个openid可能就可以窃取用户身份,因为没有验证密码
         * 2015-10-14
         */
        if ($validator && $validator->fails()) {
            return false;
        }

        if ($this->isExist($credentials['open_id'])) {
            if (!empty($this->user->app_token)) {
                //删除token
                $this->cleanToken();
            }
        } else {
            //注册用户
            $this->user = $this->provider->storeUser($credentials);
            Log::info('new user registed:'.$this->user);
            $this->provider->storeEaseMob($this->user);
        }
        //刷新token
        $token = $this->updateToken();
        return $token;
    }

    /**
     * 注销
     * @return type
     */
    public function signOut() {
        $token = Input::get('token');
        if (!empty($token)) {
            return;
        }
        $user = $this->user();
        if (!is_null($user)) {
            $this->provider->cleanToken($this->user);
            $this->cache->cleanToken($token);
            $this->user = null;
        }
    }

    /**
     * 修改用户资料
     * @param type $user
     * @param type $name
     * @param type $gender
     * @param string $avatar
     */
    public function changeProfile($profile) {
        $user = $this->user();
        if (!empty($profile['name'])) {
            $user->update(['name' => $profile['name']]);
        }
        if (!empty($profile['gender'])) {
            $user->update(['gender' => $profile['gender']]);
        }
        if (!empty($profile['avatar'])) {
            $avatar = 'http://' . QiNiu\Config::APP_URL . '/' . $profile['avatar'];
            $user->update(['avatar' =>$avatar]);
        }
    }

    /**
     * 更新token
     * @return type
     */
    public function updateToken() {
        $token = $this->cache->updateToken($this->user);
        $this->provider->updateToken($this->user, $token);
        return $token;
    }

    /**
     * 删除token
     */
    public function cleanToken() {
        $this->cache->cleanToken($this->user->app_token);
        $this->provider->cleanToken($this->user);
    }

    /**
     * 微信号是否已注册
     * @param type $open_id
     * @return type
     */
    public function isExist($open_id) {
        $this->user = Account::where('open_id', '=', $open_id)->first();
        return $this->user ? true : false;
    }

    public function isPublisher($user, $uid) {
        return $user->id == $uid;
    }

}
