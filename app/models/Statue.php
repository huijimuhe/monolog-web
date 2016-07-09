<?php

use Laracasts\Presenter\PresentableTrait;

class Statue extends Moloquent {

    const SESSION_PREFIX = 'SESSION_';  //当前正在猜的独白
    const REFRESH_PREFIX = 'REFRESH_';    //已经浏览过但没有猜的独白

    protected $collection = 'statues';
    protected $connection = 'mongodb';

    use PresentableTrait;

    protected $fillable = ['user_id', 'text', 'img_path', 'isr', 'isbanned', 'poi', 'isbanned', 'right_count', 'miss_count', 'template_type', 'seed'];
    protected $hidden = ['updated_at', 'isr', 'isbanned', 'seed'];
    protected $presenter = 'huijimuhe\Presenters\StatuePresenter';

    public function user() {
        return $this->belongsTo('Account');
    }

    public function guess() {
        return $this->hasMany('Guess');
    }

    public function ScopeByRandom($query, $poi, $guessedIds, $uid, $isr = true) {
        Log::info('Statue Get Random users,poi: ' . $poi[0] . '/' . $poi[1]);
        return $query->where('poi', 'near', $poi)
                        ->where('isbanned', '=', 0)
                        ->where('user_id', '<>', $uid)
                        ->whereNotIn('_id', $guessedIds)
                        ->orWhere(function($query) use ($isr) {
                            if (!$isr) {
                                $query->where('isr', '=', '0');
                            }
                        });
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

    public static function getSession($sid) {
        //从缓存获取statue
        $statue = Cache::get(Statue::SESSION_PREFIX . $sid);

        //如果缓存过期就数据库取
        if (!$statue) {
            $statue = Statue::find($sid);
        }

        return $statue;
    }

    public static function putSession($statue) {
        //从缓存获取statue
        $expiresAt = Carbon::now()->addMinutes(5);
        Cache::put(Statue::SESSION_PREFIX . $statue->id, $statue, $expiresAt);
    }

    public static function getRefresh($sid) {
        //从缓存获取statue
        $statue = Cache::get(Statue::REFRESH_PREFIX . $sid);

        //如果缓存过期就数据库取
        if (!$statue) {
            $statue = Statue::find($sid);
        }

        return $statue;
    }

    public static function putRefresh($statue) {
        //从缓存获取statue
        $expiresAt = Carbon::now()->addMinutes(5);
        Cache::put(Statue::REFRESH_PREFIX . $statue->id, $statue, $expiresAt);
    }

}
