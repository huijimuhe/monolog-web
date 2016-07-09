<?php

namespace huijimuhe\Repo;

use Statue,
    Profile,
    DB,
    Guess,
    huijimuhe\Core\Listeners\CreatorListener,
    huijimuhe\Core\Listeners\UpdaterListener,
    huijimuhe\Core\Listeners\DeleterListener,
    huijimuhe\Core\Exceptions\EntityNotFoundException;

class StatueRepository extends \huijimuhe\Core\Repo\EloquentRepository {

    public function __construct(Statue $model) {
        $this->model = $model;
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

    public function update(UpdaterListener $observer, $model, $data, $validator = null) {
        // check the passed in validator
        if ($validator && $validator->fails()) {
            return $observer->CreateError($validator->messages());
        }
        //导入数据
        $model->fill($data);
        // check the model validation
        if (!$this->save($model)) {
            return $observer->UpdateError($model->getErrors());
        }
        return $observer->Updated($model);
    }

    public function deleteModel(DeleterListener $observer, $model) {
        //更新用户秘密计数
    //    $model->user->decrement('statue_count');
        $this->delete($model);
        return $observer->Deleted($model);
    }

    public function deleteMulitModel($ids) {
        foreach ($ids as $id) {
            //手工删除关联数据 
            $model = $this->requireById($id);
            //更新用户秘密计数
            if ($model->user) {
                $model->user->decrement('statue_count');
            }
            $this->delete($model);
        }
        return true;
    }

}
