<?php

use huijimuhe\Repo\StatueRepository,
    huijimuhe\Repo\UserRepository,
    huijimuhe\Core\Listeners\CreatorListener,
    huijimuhe\Core\Listeners\DeleterListener;

class StatuesController extends BaseController implements CreatorListener, DeleterListener {

    protected $statueRepo;
    protected $userRepo;

    public function __construct(StatueRepository $sRepo, UserRepository $uRepo) {
        parent::__construct();
        $this->statueRepo = $sRepo;
        $this->userRepo = $uRepo;
    }

    public function index() {
        $statues = $this->statueRepo->getAllPaginated(50);
        return View::make('statues.index', compact('statues'));
    }

    public function create() {
        $u = $this->userRepo->getRandom();
        return View::make('statues.create_edit', compact('u'));
    }

    public function getOssToken() {
        $token = App::make('QiNiu\Auth')->uploadToken('duang');
        return Response::json(['uptoken' => $token]);
    }

    public function getHotMap() {
        return View::make('statues.hotmap');
    }

    public function store() {
        $data = [
            'text' => Input::get('text'),
            'img_path' => 'http://' . QiNiu\Config::APP_URL . '/' . Input::get('img_path'),
            'user_id' => Input::get('user_id'),
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
                    'user_id' => 'required',
                    'lng' => 'required|numeric|min:0;max:180',
                    'lat' => 'required|numeric|min:0;max:60',
        ]);
        return $this->statueRepo->create($this, $data, $validator);
    }

    public function show($id) {

        $statue = $this->statueRepo->requireById($id);
        return View::make('statues.show', compact('statue'));
    }

    public function postMulitDelete() {
        $ids = Input::get('ids');
        if ($this->statueRepo->deleteMulitModel($ids)) {
            return Response::make('<p>work</p>', 200);
        } else {
            return Response::make('<p>not work</p>', 501);
        }
    }

    public function destroy($id) {
        $model = $this->statueRepo->requireById($id);
        return $this->statueRepo->deleteModel($this, $model);
    }

    public function CreateError($errors) {
        Flash::error('出现错误' . $errors->first());
        return Redirect::back()->withInput();
    }

    public function Created($model) {
        Flash::success('操作成功');
        return Redirect::back()->withInput();
    }

    public function Deleted($model) {
        Flash::success('操作成功');
        return Redirect::back();
    }

}
