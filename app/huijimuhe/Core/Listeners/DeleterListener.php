<?php namespace huijimuhe\Core\Listeners;

interface DeleterListener
{
    public function Deleted($model);
}