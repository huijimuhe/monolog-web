<?php

class Report extends Moloquent {
       protected $collection = 'reports'; 
     protected $connection = 'mongodb';
    protected $fillable = ['statue_id', 'from_user_id', 'reason', 'isbanned'];

    public function statue() {
        return $this->belongsTo('Statue');
    }

    public function reporter() {
        return $this->hasOne('Account', '_id', 'from_user_id');
    }

    public function ScopeByUnRead($query) {
        return $query->where('isbanned', '=', 0);
    }

}
