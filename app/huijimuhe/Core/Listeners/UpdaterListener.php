<?php namespace huijimuhe\Core\Listeners;

interface UpdaterListener
{
    public function UpdateError($errors);
    public function Updated($model);
}