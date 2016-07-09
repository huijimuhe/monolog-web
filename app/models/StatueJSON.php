<?php

class StatueJSON extends Moloquent {

    const SESSION_PREFIX = 'SESSION_';

    protected $collection = 'statues';
    protected $connection = 'mongodb';
    protected $fillable = ['_id', 'text','user_id', 'img_path', 'right_count', 'miss_count', 'template_type'];

    public static function extract($model) {
        $res = new StatueJSON();
        $res->fill($model->toArray());
        return $res;
    }

}
