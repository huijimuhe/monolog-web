<?php

namespace huijimuhe\Presenters;

use Laracasts\Presenter\Presenter;
use Input,
    URL,
    Request,
    Statue,
    Form;

class StatuePresenter extends Presenter {

    public function backgroundImg() {
        if (!$this->img_path) {
            return ' <img  style="width:20em;height:20em;" id="img-background" src="' . $this->img_path . '" />';
        } else {
            return ' <img style="display:none;width:150px;height:150px" id="img-background" />';
        }
    }

}
