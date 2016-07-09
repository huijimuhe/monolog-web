<?php

use huijimuhe\Support\Easemob;

class Contact extends Moloquent {

    protected $collection = 'contacts';
    protected $connection = 'mongodb';
    protected $fillable = ['user_id', 'from_user_id'];
    public $timestamps = false;
 
    public static function isFriended($fromUser_id, $user_id) {
        return Contact::where('user_id', '=', $user_id)
                        ->where('from_user_id', '=', $fromUser_id)
                        ->count()!=0;
    }

    public static function friend($fUser, $tUser) {
        $follower = new Contact();
        $follower->from_user_id = $fUser->id;
        $follower->user_id = $tUser->id;
        $follower->save();
        $fUser->increment('follow_count');
        $tUser->increment('fan_count');
    }
 
    public function friendEaseMob ($from_uid, $to_uid) {
        $mob = new Easemob(); 
        $mob->addFriend($from_uid, $to_uid);
        $mob->addFriend($to_uid, $from_uid);
    }

}
