<?php

namespace huijimuhe\Repo\api;

use Illuminate\Support\Collection;
use huijimuhe\Core\Exceptions\EntityNotFoundException;
use Statue,
    Profile,
    DB,
    Guess,
    huijimuhe\Core\Listeners\CreatorListener,
    huijimuhe\Core\Listeners\UpdaterListener,
    huijimuhe\Core\Listeners\DeleterListener;

class ReortRepository extends \huijimuhe\Core\Repo\EloquentRepository {

    public function __construct(Statue $model) {
        $this->model = $model;
    }

    public function getStatue($user, $loc) {

        $db = DB::connection('mongodb')->getMongoDB(); 
        $result = $db->command([
            'geoNear' => "statues",
            'near' => $loc,
            'spherical' => true, // 启用特殊搜索
            'num' => 100,
            'query' => ['user_id' => ['$ne' => 2]], //不算入自己
        ]);
  
        for ($i = 0; $i < 10; $i++) {
            $loc[0] = $loc[0] + $i * 0.5;
            $loc[1] = $loc[1] + $i * 0.5;
            $result = Statue::where('loc', 'near', $loc)
                            ->whereNotIn('user_id', [$user->id])->take(100)->get(); 
            $count = 0;
            while (true) {
                if ($count == count($result)) {
                    return null;
                }
                $statue = $result[mt_rand(0, count($result) - 1)];
                if (!Guess::isGuessed($statue->id, $user) && $statue->user_id != $user->id) {
                    return $statue;
                }
                $count++;
            }
        }
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
        if ($validator && !$validator->isValid()) {
            return $observer->CreateError($validator->getErrors());
        }
//建MODEL
        $model = $this->getNew($data);
//存MODEL
        if (!$this->save($model)) {
            return $observer->CreateError($model->getErrors());
        }
//写入lbs
        Lbs2Repository::createStatuePOI($model);
//更新用户秘密计数
        Profile::where('user_id', '=', $model->user->id)->increment('statue_count');
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
//写入lbs云
        Lbs2Repository::udateStatuePOI($model);
        return $observer->Updated($model);
    }

    public function deleteModel(DeleterListener $observer, $model) {

//手工删除关联数据 
//写入lbs
        Lbs2Repository::deleteStatuePOI($model);
//更新用户秘密计数
        Profile::where('user_id', '=', $model->user->id)->decrement('statue_count');
        $this->delete($model);
        return $observer->Deleted($model);
    }

    public function deleteMulitModel($ids) {

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
