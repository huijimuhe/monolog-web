<?php

use huijimuhe\Repo\ReportRepository,
    huijimuhe\Core\Listeners\CreatorListener,
    huijimuhe\Core\Listeners\UpdaterListener,
    huijimuhe\Core\Listeners\DeleterListener;

class ReportsController extends BaseController implements UpdaterListener {

    protected $rRepo;

    public function __construct(ReportRepository $rRepo) {
        parent::__construct();
        $this->rRepo = $rRepo;
    }

    public function index() {
        $reports = $this->rRepo->getAllPaginated(50);
        return View::make('reports.index', compact('reports'));
    }

    public function postDeal($id) {
        $type = Input::get('deal', 0);
        $model = $this->rRepo->requireById($id);
        return $this->rRepo->deal($this, $model, $type);
    }

    public function UpdateError($errors) {
        Flash::error('出现错误' . $errors->getMessages()->first());
        return Route::back()->withInput();
    }

    public function Updated($model) {
        Flash::success('操作成功');
        return Redirect::back();
    }

}
