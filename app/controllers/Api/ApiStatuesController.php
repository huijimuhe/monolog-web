<?php

use huijimuhe\Repo\api\StatueRepository,
    huijimuhe\Repo\api\UserRepository,
    huijimuhe\Core\Listeners\CreatorListener,
    huijimuhe\Core\Listeners\DeleterListener,
    huijimuhe\Auth\Guard;

class ApiStatuesController extends BaseController implements CreatorListener, DeleterListener {

    protected $statueRep;
    protected $userRep;
    protected $auth;

    public function __construct(UserRepository $userRep, StatueRepository $statueRep, Guard $auth) {
        $this->userRep = $userRep;
        $this->statueRep = $statueRep;
        $this->auth = $auth;
    }

    public function getStatue() {
        $guesser = $this->auth->user();
        $poi = [(double) Input::get('lng'), (double) Input::get('lat')];

        //用户更新当前坐标
        $this->userRep->UpdatePoi($guesser, $poi);

        //获取随机独白
        $statue = $this->statueRep->getRandom($guesser->id, $poi);

        //没有数据的极端情况
        if (!$statue) {
            return Response::make(400, 400);
        }

        //获取随机用户
        $users = $this->userRep->getRandoms($guesser, $statue->user);

        return Response::json(['statue' => StatueJSON::extract($statue), 'users' => $users]);
    }

    public function postGuess() {

        $user = $this->auth->user();

        $inputs = [
            'sid' => Input::get('sid'),
            'uid' => Input::get('uid'),
        ];
         
        Log::info($user->name.' postedGuess-->' . Input::get('sid') . 'uid-->' . Input::get('uid'));
        
        $validator = Validator::make($inputs, [
                    'sid' => 'required',
                    'uid' => 'required',
        ]);

        $res = $this->statueRep->guess($this, $inputs, $user, $validator);

        return Response::json(['result' => $res==null ? 0 : 1, 'user' => AccountJSON::extract($res->user)]);
    }

    public function getMyStatues($page = 0) {
        $user = $this->auth->user();
        $query = $this->statueRep->getStatueListByPaginate($user, $page);
        return Response::json(['items' => $query, 'total_number' => isset($query) ? $query->count() : 0]);
    }

    public function getUserStatues($page = 0) {
        $user = Account::find(Input::get('user_id'));
        $query = $this->statueRep->getStatueListByPaginate($user, $page);
        return Response::json(['items' => $query, 'total_number' => isset($query) ? $query->count() : 0]);
    }

    public function getMyGuess($type, $page = 0) {
        $user = $this->auth->user();
        $query = $this->statueRep->getMyGuessListByPaginate($type, $user, $page);
        return Response::json(['items' => $query, 'total_number' => isset($query) ? $query->count() : 0]);
    }

    public function getOssToken() {
        $token = App::make('QiNiu\Auth')->uploadToken('duang');
        return Response::make($token, 200);
    }

    public function postCreate() {

        $user = $this->auth->user();

        //保存秘密
        $data = [
            'text' => Input::get('text'),
            'user_id' => $user->id,
            'img_path' => 'http://' . QiNiu\Config::APP_URL . '/' . Input::get('img_path'),
            'lng' => Input::get('lng'),
            'lat' => Input::get('lat'),
            'isr' => 0,
            'isbanned' => 0,
            'right_count' => 0,
            'miss_count' => 0,
            'template_type' => 1,
            'seed' => rand(1, 1000000),
            'poi' => [(double) Input::get('lng'), (double) Input::get('lat')]];

        $validator = Validator::make($data, [
                    'text' => 'required|max:120',
                    'lng' => 'required|numeric|min:0;max:180',
                    'lat' => 'required|numeric|min:0;max:60',
        ]);

        return $this->statueRep->create($this, $data, $validator);
    }

    public function postDestory() {
        $sid = Input::get('id');
        $s = Statue::find($sid);
        $user = $this->auth->user();
        if (!$s) {
            return Response::make(402, 400);
        }
        if ($user->id == $s->user_id) {
            return $this->statueRep->deleteModel($this, $s);
        } else {
            return Response::make(405, 400);
        }
    }

    public function CreateError($errors) {
        return Response::json($errors->first(), 400);
    }

    public function Created($model) {
        return Response::json($model);
    }

    public function Deleted($model) {
        return Response::make(203, 200);
    }

}
