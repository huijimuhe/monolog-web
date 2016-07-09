<?php

use huijimuhe\Repo\api\StatueRepository,
    huijimuhe\Repo\api\UserRepository,
    huijimuhe\Auth\Guard;

class HomeController extends BaseController {

    protected $auth;

    public function __construct(UserRepository $userRep, StatueRepository $statueRep, Guard $auth) {
        $this->userRep = $userRep;
        $this->statueRep = $statueRep;
        $this->auth = $auth;
    }

    public function Welcome() {
        
    }
  
    public function dashBoard() {
        $size = [
            'uTotal' => Account::count(),
            'uWeek' => Account::ByWeekCount()->count(),
            'uMonth' => Account::ByMonthCount()->count(),
            'uToday' => Account::ByTodayCount()->count(),
            'sTotal' => Statue::count(),
            'sWeek' => Statue::ByWeekCount()->count(),
            'sMonth' => Statue::ByMonthCount()->count(),
            'sToday' => Statue::ByTodayCount()->count(),
        ];
        return View::make('dashboard', compact('size'));
    }

    public function install() {
        //检查是否已初始化
        $file = app_path() . '/config/install.lock';
        if (is_file($file)) {
            echo '安装文件已存在<br>已经初始化';
            return;
        }
        //初始化用户
        $salt = md5(\Str::random(64) . time());
        $user = new User();
        $data = [
            'name' => 'admin',
            'phone' => '110',
            'password' => '[YOURS]',//TODO [YOURS]
            'salt' => $salt,];
        $user->fill($data);
        $user->save();
        //初始化账户信息
        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->gender = 'm';
        $profile->avatar = '-1';
        $profile->save();
        echo '生成管理员.....完成<br>';
        //生成lock文件
        fopen($file, "w");
        echo '生成lock文件.....完成<br>';
    }

}
