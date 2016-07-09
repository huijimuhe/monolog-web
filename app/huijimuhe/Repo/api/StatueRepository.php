<?php

namespace huijimuhe\Repo\api;

use Statue,
    Guess,
    Contact,
    App,
    Log,
    huijimuhe\Core\Listeners\CreatorListener,
    huijimuhe\Core\Listeners\UpdaterListener,
    huijimuhe\Core\Listeners\DeleterListener;

class StatueRepository extends \huijimuhe\Core\Repo\EloquentRepository {

    public function __construct(Statue $model) {
        $this->model = $model;
    }

    /**
     * 获取随机独白 
     * @param type $uid
     * @param type $poi
     * @return type
     */
    public function getRandom($uid, $poi) {
        //获取猜过的ID 
        $guessedIds = Guess::getUserGuessedIds($uid);

        //获取随机的一个独白  
        $statue = Statue::ByRandom($poi, $guessedIds, $uid)->first(); //->first(['id', 'text', 'img_path', 'right_count', 'miss_count']);
        //添加session
        if ($statue) {
            Statue::putSession($statue);
        }

        return $statue;
    }

    /**
     * 猜结果
     *
     * @param \huijimuhe\Core\Listeners\CreatorListener $observer
     * @param type $inputs
     * @param type $user
     * @param type $validator
     * @return boolean
     */
    public function guess(CreatorListener $observer, $inputs, $user, $validator = null) {

        if ($validator && $validator->fails()) {
            return $observer->CreateError($validator->messages());
        }

        //已猜过了直接显示已猜测
        if (Guess::isGuessed($inputs['sid'], $user)) {
            return false;
        }

        //从缓存获取statue
        $statue = Statue::getSession($inputs['sid']);

        Log::info('(StatueRepository.guess: sid)' . $statue->id . '->statue\'s user id' . $statue->user->id);

        //猜错了
        if ($statue->user->id != $inputs['uid']) {
            //添加猜谜
            Guess::notify($inputs['sid'], $statue->user->id, $user->id, 0);
            Guess::updateUserGuessedIds($user->id, $inputs['sid']);
            //添加计数
            $statue->increment('miss_count');
            $user->increment('miss_count');
            return null;
        }

        //猜对了
        //添加猜谜
        Guess::notify($inputs['sid'], $statue->user->id, $user->id, 1);
        Guess::updateUserGuessedIds($user->id, $inputs['sid']);
        //添加计数
        $statue->increment('right_count');
        $user->increment('right_count');

        //加联系人
        if (!Contact::isFriended($user->id, $statue->user->id)) {
            Contact::friend($user, $statue->user);
        }
        //easemob加好友
        Contact::friend($user, $statue->user);
        //easemob加好友
        //  App::make('huijimuhe\Auth\UserProvider')->friend($user->id, $statue->user->id);

        return $statue;
    }

    public function getMyGuessListByPaginate($type, $user, $page = 0) {

        $query = Guess::where('from_user_id', '=', $user->id);
        switch ($type) {
            case 'right':
                $query = $query->where('result', '=', 1);
                $query = $this->getList($query, $page)->lists('statue_id');
                return Statue::whereIn('_id', $query)->with('user')->get(['_id', 'user', 'user_id', 'text', 'img_path', 'miss_count', 'right_count', 'created_at']);
            case 'miss':
                $query = $query->where('result', '=', 0);
                $query = $this->getList($query, $page)->lists('statue_id');
                return Statue::whereIn('_id', $query)->get(['_id', 'user', 'user_id', 'text', 'img_path', 'miss_count', 'right_count', 'created_at']);
        }
    }

    public function getStatueListByPaginate($user, $page = 0) {
        $query = Statue::where('user_id', '=', $user->id);
        $query = $this->getList($query, $page)->with('user')->get();
        return $query;
    }

    public function isRight($id, $user_id) {
        $guess = Guess::where('statue_id', '=', $id)
                        ->where('from_user_id', '=', $user_id)->first();
        if ($guess && $guess->result == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function create(CreatorListener $observer, $data, $validator = null) {

        //验证
        if ($validator && $validator->fails()) {
            return $observer->CreateError($validator->messages());
        }

        //建MODEL
        $model = $this->getNew($data);

        //存MODEL
        if (!$this->save($model)) {
            return $observer->CreateError($model->getErrors());
        }

        //更新用户秘密计数
        $model->user->increment('statue_count');
        return $observer->Created($model);
    }

    public function deleteModel(DeleterListener $observer, $model) {
        //更新用户秘密计数
        $model->user->decrement('statue_count');
        $this->delete($model);
        return $observer->Deleted($model);
    }

}
