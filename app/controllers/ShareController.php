<?php

class ShareController extends BaseController {
 
    public function __construct() {
        parent::__construct(); 
    }
 
    public function index() {
        return View::make('share.index');
    }
  
}
