<?php

class Open extends \Eloquent {

    protected $fillable = ['user_id', 'type', 'open_id', 'token','refresh_token']; 

    public function user() {
        return $this->belongsTo('User');
    }

}
