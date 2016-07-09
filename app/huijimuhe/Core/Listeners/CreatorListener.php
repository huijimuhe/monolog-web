<?php namespace huijimuhe\Core\Listeners;

interface CreatorListener
{
    public function CreateError($errors);
    public function Created($model);
}