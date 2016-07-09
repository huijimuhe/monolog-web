<?php

use huijimuhe\Auth\Guard;

class ApiContactsController extends BaseController {

    protected $auth;

    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }

    public function getContact() {
        $name = Input::get('name');
        $account = Account::ByEaseUser($name);
        return Response::json(AccountJSON::extract($account));
    }

    public function getContacts() {
        /**
         * 应该写repository,
         * 图省事了
         */
        $user = $this->auth->user();

        $uid_fans = Contact::where('user_id', '=', $user->id)->lists('from_user_id');
        $uid_follows = Contact::where('from_user_id', '=', $user->id)->lists('user_id');
        $uid_total = array_merge($uid_fans, $uid_follows);
        if (count($uid_total) == 0) {
            return Response::json();
        }

        $query = Account::whereIn('_id', $uid_total)->get(['id', 'name', 'avatar', 'gender']);
        return Response::json($query);
    }

}
