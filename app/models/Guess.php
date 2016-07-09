<?php

class Guess extends Moloquent {

    protected $collection = 'guesses';
    protected $connection = 'mongodb';
    protected $fillable = ['user_id', 'from_user_id', 'statue_id', 'result', 'is_readed'];
    protected $hidden = ['updated_at']; 

    const CACHE_PREFEX = 'GUESS_CACHE_';

    public function user() {
        return $this->belongsTo('Account', 'from_user_id');
    }

    public function statue() {
        return $this->hasOne('Statue');
    }
  
    public static function isGuessed($sid, $user) {
        $guess = Guess::where('statue_id', '=', $sid)
                        ->where('from_user_id', '=', $user->id)->first();
        return $guess ? true : false;
    }

    public static function isRight($id, $user_id) {
        $guess = Guess::where('statue_id', '=', $id)
                        ->where('from_user_id', '=', $user_id)->first();
        return $guess->result == 1 ? true : false;
    }

    public static function notify($sid, $user_id, $from_user_id, $result) {
        $guess = new Guess();
        $guess->statue_id = $sid;
        $guess->user_id = $user_id;
        $guess->from_user_id = $from_user_id;
        $guess->result = $result;
        $guess->save();
    }

    public static function getUserGuessedIds($uid) {
        //从缓存读取已猜过的id号
        $ids = Cache::get(Guess::CACHE_PREFEX . $uid);

        if (!$ids) {
            //如果没有缓存就加载
            $ids = Guess::where('from_user_id', '=', $uid)
                    ->lists('statue_id');
            //避免产生空数组，随便拿一个
            if (count($ids) == 0) {
                $ids[] = '00000000';
            }
            //载入缓存
            $expiresAt = Carbon::now()->addMinutes(10);
            Cache::put(Guess::CACHE_PREFEX . $uid, $ids, $expiresAt);
        }

        return $ids;
    }

    public static function updateUserGuessedIds($uid, $sid) {
        //从缓存读取已猜过的id号
        $ids = Cache::get(Guess::CACHE_PREFEX . $uid);
        $ids[] = $sid;
        $expiresAt = Carbon::now()->addMinutes(10);
        Cache::put(Guess::CACHE_PREFEX . $uid, $ids, $expiresAt);
        return $ids;
    }

}
