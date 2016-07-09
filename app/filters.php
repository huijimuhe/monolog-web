<?php

/*
  |--------------------------------------------------------------------------
  | Application & Route Filters
  |--------------------------------------------------------------------------
  |
  | Below you will find the "before" and "after" events for the application
  | which may be used to do any work before or after a request into your
  | application. Here you may also register your custom route filters.
  |
 */

App::before(function($request) {
    //
});


App::after(function($request, $response) {
    //
});

/*
  |--------------------------------------------------------------------------
  | Authentication Filters
  |--------------------------------------------------------------------------
  |
  | The following filters are used to verify that the user of the current
  | session is logged into this application. The "basic" filter easily
  | integrates HTTP Basic authentication for quick, simple checking.
  |
 */
 
Route::filter('auth', function() {
    if (Auth::guest()) {
        if (Request::ajax()) {
            return Response::make(403, 400);
        }
        return Redirect::guest('login');
    }
});


Route::filter('auth.basic', function() {
    return Auth::basic();
});

/*
  |--------------------------------------------------------------------------
  | Guest Filter
  |--------------------------------------------------------------------------
  |
  | The "guest" filter is the counterpart of the authentication filters as
  | it simply checks that the current user is not logged in. A redirect
  | response will be issued if they are, which you may freely change.
  |
 */

Route::filter('guest', function() {
    if (Auth::check())
        return Redirect::to('/');
});

/*
  |--------------------------------------------------------------------------
  | CSRF Protection Filter
  |--------------------------------------------------------------------------
  |
  | The CSRF filter is responsible for protecting your application against
  | cross-site request forgery attacks. If this special token in a user
  | session does not match the one given in this request, we'll bail.
  |
 */

Route::filter('csrf', function() {
    if (Session::token() !== Input::get('_token')) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});

Route::filter('IpBanner', function() {
    $ip = Request::ip(); //获取IP
    if (Cache::has($ip)) {//是否有这个IP
        if (Cache::get($ip) > 100) {//是否超过100次限制
           return Response::make(404, 400);
        } else {//没有就自加1
            Cache::increment($ip);
        }
    } else {//没有这IP就创建一个，过期时间设置为1分钟
        $expiresAt = Carbon::now()->addMinutes(1);
        Cache::put($ip, 0, $expiresAt);
    }
});

Route::filter('ApiAuth', function() {
    /*     * *********************
     * cacahe检查是否有该用户:用户名/TOKEN都取出来对比检查
     * 如果cacahe中没有：数据库中找（用户名，remember_token交叉检查）
     * 如果数据库有：就更新cacahe，更新rememberme_token 
     * 返回它的token编号
     * 
     * 好学的胖子 2015.2.26
     * ********************** */  
    if (!App::make('huijimuhe\Auth\Guard')->check()) {
        return Response::make(403, 400);
    }
});
