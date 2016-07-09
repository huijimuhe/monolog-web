<?php

namespace huijimuhe\Repo;

use Account,
    Profile,
    Hash,
    QiNiu,
    Auth,
    huijimuhe\Core\Repo\EloquentRepository,
    huijimuhe\Core\Listeners\CreatorListener,
    huijimuhe\Core\Listeners\UpdaterListener,
    huijimuhe\Core\Listeners\DeleterListener,
    huijimuhe\Core\Exceptions\EntityNotFoundException;

class UserRepository extends EloquentRepository {

    public function __construct(Account $model) {
        $this->model = $model;
    }

    public function getRandom() {
        $seed = rand(0, Account::count());
        return $this->model->ByRandom($seed)->first();
    }

    public function create(CreatorListener $observer, $data, $validator = null) {
        //验证
        if ($validator && $validator->fails()) {
            return $observer->CreateError($validator->messages());
        }
        //建MODEL
        $model = $this->getNew()->fill($data);
        //存MODEL
        if (!$this->save($model)) {
            return $observer->CreateError($model->getErrors());
        }
        //存关联profile 
        $profile = new Profile();
        $profile = $profile->fill($data);
        $model->profile()->save($profile);
        return $observer->Created($model);
    }

    public function update(UpdaterListener $observer, $model, $data, $validator = null) {
        // check the passed in validator
        if ($validator && $validator->fails()) {
            return $observer->CreateError($validator->messages());
        }

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($model->salt . $data['password']);
        }

        $model->fill($data);

        if (!$this->save($model)) {
            return $observer->UpdateError($model->getErrors());
        }

        if (empty($data['avatar'])) {
            unset($data['avatar']);
        } else {
            $data['avatar'] = 'http://' . QiNiu\Config::APP_URL . '/' . $data['avatar'];
        }

        $model->profile->update($data);
        return $observer->Updated($model);
    }

    /**
     * 删除
     * @param \Ma\Repo\TopicCatalog\DeleterListener $observer
     * @param type $model
     * @return type
     */
    public function deleteModel(DeleterListener $observer, $model) {
        $this->delete($model); 
        return $observer->Deleted($model);
    }

    public function deleteMulitModel($ids) {
        foreach ($ids as $id) {
            //手工删除关联数据 
            $model = $this->requireById($id);
            //写入lbs
            Lbs2Repository::deleteUserPOI($model);
            //更新用户
            $this->delete($model);
            $model->profile->delete();
        }
        return true;
    }

}
