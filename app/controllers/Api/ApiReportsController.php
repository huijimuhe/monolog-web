<?php

use huijimuhe\Repo\ReportRepository,
    huijimuhe\Auth\Guard,
    huijimuhe\Core\Listeners\CreatorListener;

class ApiReportsController extends BaseController implements CreatorListener {

    protected $repo;
    protected $auth;

    public function __construct(ReportRepository $repo, Guard $auth) {
        parent::__construct();
        $this->repo = $repo;
        $this->auth = $auth;
    }

    /**
     * Show the form for creating a new resource.
     * GET /statues/create
     *
     * @return Response
     */
    public function postReport() {
        //  
        $user = $this->auth->user();
        $data = [
            'statue_id' => Input::get('sid'),
            'from_user_id' => $user->id,
            'reason' => Input::get('reason', '有问题')
        ];
        return $this->repo->create($this, $data);
    }

    /**
     * ----------------------------------------
     * CreatorListener Delegate
     * ----------------------------------------
     */
    public function CreateError($errors) {
        return Response::make($errors->getMessages()->first(), 400);
    }

    public function Created($model) {
        return Response::make(1, 200);
    }

}
