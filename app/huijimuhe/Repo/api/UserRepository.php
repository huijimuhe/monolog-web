<?php

namespace huijimuhe\Repo\api;

use Account,
    Log;

class UserRepository extends \huijimuhe\Core\Repo\EloquentRepository {

    public function __construct(Account $model) {
        $this->model = $model;
    }

    public function UpdatePoi($u, $poi) {
        $u->update(['poi' => $poi]);
    }

    public function getRandoms($guesser,$publisher) {
        $total = Account::count();
        $seed1 = rand(0, $total/2);
        $seed2 = rand($total/2+1, $total-2);
        
        Log::info('Account Get Random users,seed1: ' . $seed1 . '   seed2:' . $seed2.'publisher\'s id is:'.$publisher->id);
        $users[] = $this->model
               ->ByRandom($seed1,$guesser->id)
                ->first(['_id', 'name', 'avatar']);

        $users[] = $this->model 
                ->ByRandom($seed2,$guesser->id)
                ->first(['_id', 'name', 'avatar']);

        $users[] = Account::where('_id','=',$publisher->id)->first(['_id', 'name', 'avatar']);

      //  shuffle($users);
        return $users;
    }

}
