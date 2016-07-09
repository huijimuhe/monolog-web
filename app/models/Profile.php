<?php

class Profile extends \Eloquent {

    protected $fillable = ['user_id', 'gender', 'avatar','score'];
    public $timestamps = false;

    public function user() {
        return $this->belongsTo('User');
    }

}
