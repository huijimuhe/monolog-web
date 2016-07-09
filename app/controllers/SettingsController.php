<?php

use huijimuhe\Repo\SettingRepository,
    huijimuhe\Core\Listeners\CreatorListener,
    huijimuhe\Core\Listeners\UpdaterListener,
    huijimuhe\Core\Listeners\DeleterListener;

class SettingsController extends BaseController implements CreatorListener, DeleterListener, UpdaterListener {

    protected $repo;

    public function __construct(SettingRepository $repo) {
        parent::__construct();
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     * GET /settings
     *
     * @return Response
     */
    public function index() {
        $settings = $this->repo->getAllPaginated(50);
        return View::make('settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     * GET /settings/create
     *
     * @return Response
     */
    public function create() {
        return View::make('settings.create_edit');
    }

    public function edit($id) {
        $setting = $this->repo->requireById($id);
        return View::make('settings.create_edit')->with('setting', $setting);
    }

    public function store() {
        $data = [
            'name' => Input::get('name'),
            'val' => Input::get('val'),
            'val2' => Input::get('val2'),
            'val3' => Input::get('val3'),];
        return $this->repo->create($this, $data);
    }

    public function update($id) {
        $model = $this->repo->requireById($id);
        $data = [
            'name' => Input::get('name'),
            'val' => Input::get('val'),
            'val2' => Input::get('val2'),
            'val3' => Input::get('val3'),];
        return $this->repo->update($this, $model, $data);
    }

    public function show($id) {
        //
        $statue = $this->repo->requireById($id);
        return View::make('settings.show', compact('statue'));
    }

    public function getAgreement() {
        $agreemnet = Setting::where('name', '=', '用户协议')->first();
        return $agreemnet->val;
    }

    public function postMulitDelete() {
        $ids = Input::get('ids');
        if ($this->repo->deleteMulitModel($ids)) {
            return Response::make('<p>work</p>', 200);
        } else {
            return Response::make('<p>not work</p>', 501);
        }
    }

    public function destroy($id) {
        $model = $this->repo->requireById($id);
        return $this->repo->deleteModel($this, $model);
    }

    /**
     * ----------------------------------------
     * CreatorListener Delegate
     * ----------------------------------------
     */
    public function CreateError($errors) {
        Flash::error('出现错误' + $errors->getMessages()->first());
        return Route::back()->withInput();
    }

    public function Created($model) {

        Flash::success('操作成功');
        return Redirect::back()->withInput();
    }

    public function Deleted($model) {
        Flash::success('操作成功');
        return Redirect::back();
    }

    public function UpdateError($errors) {
        Flash::error('出现错误' + $errors->getMessages()->first());
        return Route::back()->withInput();
    }

    public function Updated($model) {
        Flash::success('操作成功');
        return Redirect::back();
    }

}
