<?php namespace huijimuhe\Core\Listeners;

interface AuthListener
{
    public function CreateError($errors);
    public function Created($model);
}