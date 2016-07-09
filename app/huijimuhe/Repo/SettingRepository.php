<?php

namespace huijimuhe\Repo;

use huijimuhe\Core\Exceptions\EntityNotFoundException;
use Setting,
    huijimuhe\Core\Listeners\CreatorListener,
    huijimuhe\Core\Listeners\UpdaterListener,
    huijimuhe\Core\Listeners\DeleterListener;

class SettingRepository extends \huijimuhe\Core\Repo\EloquentRepository {

    public function __construct(Setting $model) {
        $this->model = $model;
    }

    public function create(CreatorListener $observer, $data, $validator = null) {
        //验证
        if ($validator && !$validator->isValid()) {
            return $observer->CreateError($validator->getErrors());
        }
        //建MODEL
        $model = $this->getNew($data);
        //存MODEL
        if (!$this->save($model)) {
            return $observer->CreateError($model->getErrors());
        }

        return $observer->Created($model);
    }

    public function update(UpdaterListener $observer, $model, $data, $validator = null) {
        // check the passed in validator
        if ($validator && !$validator->isValid()) {
            return $observer->UpdateError($validator->getErrors());
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
        $this->delete($model);
        return $observer->Deleted($model);
    }

    public function deleteMulitModel($ids) {
        foreach ($ids as $id) {
            //手工删除关联数据 
            $model = $this->requireById($id);
            $this->delete($model);
        }
        return true;
    }

}
