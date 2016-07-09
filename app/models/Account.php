<?php
 
use Laracasts\Presenter\PresentableTrait;

class Account extends Moloquent {

    use PresentableTrait;

    protected $collection = 'accounts';
    protected $connection = 'mongodb';
    protected $presenter = 'huijimuhe\Presenters\UserPresenter';
    protected $fillable = [ 'name', 'avatar', 'salt', 'password', 'gender', 'poi', 'open_id', 'token', 'isr', 'miss_count', 'right_count', 'statue_count','fan_count', 'isbanned', 'app_token', 'poi'];
    protected $hidden = ['salt', 'password', 'app_token', 'open_id', 'created_at', 'updated_at', 'isr', 'isbanned', 'token'];

    public function statues() {
        return $this->hasMany('Statue');
    }

    public function reports() {
        return $this->hasMany('Report', 'from_user_id');
    }

    public function ScopeByToken($query, $token) {
        return $query->where('app_token', '=', $token)->first();
    }
    public function ScopeByEaseUser($query, $name) {
        return $query->where('_id', '=', $name)->first();
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

    public function ScopeByRandom($query, $seed, $excluedId, $isr = true) {
        return $query->where('isbanned', '=', 0)
                        ->where('_id', '<>', $excluedId)
                        ->orWhere(function($query) use ($isr) {
                            if (!$isr) {
                                $query->where('isr', '=', '0');
                            }
                        })
                        ->skip($seed)
                        ->take(1);
    }

}

class AccountJSON extends Moloquent {

    protected $collection = 'accounts';
    protected $connection = 'mongodb';
    protected $fillable = ['_id', 'name', 'avatar', 'gender', 'miss_count', 'right_count', 'statue_count'];

    public static function extract($model) {
        $res = new AccountJSON();
        $res->fill($model->toArray());
        return $res;
    }

}
