<?php

namespace huijimuhe\Repo;

use huijimuhe\Core\Exceptions\EntityNotFoundException,
    Report,
    DB,
    huijimuhe\Core\Listeners\CreatorListener,
    huijimuhe\Core\Listeners\UpdaterListener,
    huijimuhe\Core\Listeners\DeleterListener;

class ReportRepository extends \huijimuhe\Core\Repo\EloquentRepository
{

    public function __construct(Report $model)
    {
        $this->model = $model;
    }

    public function create(CreatorListener $observer, $data, $validator = null)
    {
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

    public function deal(UpdaterListener $observer, $model, $type)
    {
        switch ($type) {
            case 0:
                $model->update(['isbanned' => 1]);
                $model->statue->update(['isbanned' => 1]);
                break;
            case 1:
                $model->update(['isbanned' => 1]);
                $model->statue->update(['isbanned' => 1]);
                break;
        }

        return $observer->Updated($model);
    }

    public function dealMulitModel(UpdaterListener $observer, $ids)
    {

        foreach ($ids as $id) {
            $model = $this->requireById($id);
            $model->update(['isbanned' => 1]);
        }
        return $observer->Updated(null);
    }

    public function deleteModel(DeleterListener $observer, $model)
    {

        $this->delete($model);
        return $observer->Deleted($model);
    }

    public function deleteMulitModel($ids)
    {

        foreach ($ids as $id) {
//手工删除关联数据 
            $model = $this->requireById($id);
//写入lbs
            Lbs2Repository::deleteStatuePOI($model);
//更新用户秘密计数
            if ($model->user) {
                Profile::where('user_id', '=', $model->user->id)->decrement('statue_count');
            }
            $this->delete($model);
        }
        return true;
    }

}
