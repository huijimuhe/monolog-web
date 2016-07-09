<?php

class BaseController extends Controller {

    public function __construct() {
        // csrf check for every post request
        //$this->beforeFilter('csrf', ['on' => 'post']); 
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout() {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
        View::share('currentUser', Auth::user());
    }

    protected function getTimeLine($query, $since_id, $max_id) {
        //分页
        if ($since_id == 0) {
            if ($max_id != 0) {
                $query = $query->where('id', '<', $max_id);
            }
        } else {
            $query = $query->where('id', '>', $since_id);
        }

        //取得经验
        $query = $query->orderBy('id', 'desc')
                ->take(20)
                ->get();
        return $query;
    }

    protected function getList($query, $page) {
        $query = $query->skip($page * 20)
                ->take(20)
                ->get();
        return $query;
    }
   
}
