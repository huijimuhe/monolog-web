<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Zizaco\Entrust\HasRole;
use Laracasts\Presenter\PresentableTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait,
        HasRole,
        PresentableTrait;

    protected $presenter = 'huijimuhe\Presenters\UserPresenter';
    protected $hidden = ['password', 'remember_token'];
    protected $fillable = [ 'name', 'phone', 'password','app_token', 'salt', 'is_r'];

    public function profile() {
        return $this->hasOne('Profile');
    }

    public function open() {
        return $this->hasMany('Open');
    }

    public function statues() {
        return $this->hasMany('Statue');
    }

    public function fans() {
        return $this->hasMany('Follower', 'user_id');
    }

    public function followers() {
        return $this->hasMany('Follower', 'from_user_id');
    }

    public function reports() {
        return $this->hasMany('Report', 'from_user_id');
    }

    public function getUserAttribute() {
        return $this->attributes['profile'] = Profile::where('id', '=', $this->user_id)->get()->first();
    }

    public function ScopeByToken($query, $token) {
        return $query->where('app_token', '=', $token)->first();
    }

    public function ScopeByTodayCount($query) {
        $timestamp = Carbon::today();
        return $query->where('created_at', '>', $timestamp);
    }

    public function ScopeByWeekCount($query) {
        $timestamp = Carbon::today()->startOfWeek();
        return $query->where('created_at', '>', $timestamp);
    }

    public function ScopeByMonthCount($query) {
        $timestamp = Carbon::today()->startOfMonth();
        return $query->where('created_at', '>', $timestamp);
    }

    public function ScopeByRandom($query) {
        //随机
        $prefix = Config::get('database')['connections']['mysql']['prefix'];
        $raw = DB::raw('(SELECT FLOOR( RAND() * ((SELECT MAX(id) FROM `' . $prefix . 'users`)'
                        . '-(SELECT MIN(id) FROM `' . $prefix . 'users`)) '
                        . '+ (SELECT MIN(id) FROM `' . $prefix . 'users`))) ');
        return $query->where('is_r', '=', 1)
                        ->where('id', '>=', $raw)
                        ->orderBy('id')
                        ->limit(1);
    }
}
