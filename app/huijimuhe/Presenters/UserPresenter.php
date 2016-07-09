<?php

namespace huijimuhe\Presenters;

use Laracasts\Presenter\Presenter;
use User,
    Profile,
    Form;

class UserPresenter extends Presenter {

    public function avatar() {
        if (!empty($this->profile->avatar)) {
            return ' <img class="img-circle" id="img-avatar" src="' . $this->profile->avatar . '" style="width:50px;height:50px;"/>';
        } else {
            return ' <img class="bg-yellow img-circle" id="img-avatar" />';
        }
    }

    public function genderSelector() {
        $opts = ['f' => '女', 'm' => '男'];
        if (!empty($this->profile->gender)) {
            return Form::select('gender', $opts, $this->profile->gender, ['class' => 'form-control']);
        } else {
            return Form::select('gender', $opts, null, ['class' => 'form-control']);
        }
    }

}
