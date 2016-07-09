<?php
/**
 * DEPRECATED
 * 百度云的增删改查必须要id，其他搜索条件不能用
 */
namespace huijimuhe\Repo;

use Illuminate\Support\Collection;
use huijimuhe\Core\Exceptions\EntityNotFoundException;
use DB,
    App;

class BaiduLbsRepository extends \huijimuhe\Core\Repo\EloquentRepository {

    const GEOTABLE_ID = "[YOURS]";//TODO [YOURS]
    const BAIDU_AK = '[YOURS]';//TODO [YOURS]
    const AGENT = "Mozilla/4.0 (compatible; MSIE 5.0; Windows NT 5.0)";
    const CREATE_POI = "http://api.map.baidu.com/geodata/v3/poi/create";
    const UPDATE_POI = "http://api.map.baidu.com/geodata/v3/poi/update";
    const DELETE_POI = "http://api.map.baidu.com/geodata/v3/poi/delete";
    const NEARBY_POI = "http://api.map.baidu.com/geosearch/v3/nearby";

    /**
     * 创建lbs云表
     * 字段直接后台设置，免得麻烦
     * mid:对应的用户或独白的id号
     * mtype:类型s/u
     * @param type $name
     * @return type
     */
    public static function createTable($name) {
        $snoopy = App::make('Snoopy');
        $snoopy->agent = LbsRepository::AGENT;
        $form['name'] = $name;
        $form['geotype'] = '1';
        $form['is_published'] = '1';
        $form['ak'] = LbsRepository::BAIDU_AK;

        $snoopy->submit(LbsRepository::CREATE_TABLE_URL, $form);
        $res = json_decode($snoopy->results);
        return $res->status;
    }

    public static function createPOI($model, $mtype) {
        $snoopy = App::make('Snoopy');
        $snoopy->agent = LbsRepository::AGENT;
        $form['ak'] = LbsRepository::BAIDU_AK;
        $form['geotable_id'] = LbsRepository::GEOTABLE_ID; 
        $form['latitude'] = $model->lat;
        $form['longitude'] = $model->lng;
        $form['coord_type'] = '3';
        $form['title'] = $model->id;
        $form['mid'] = $model->id;
        $form['tags'] = $mtype;
        $form['mtype'] = $mtype;
        $snoopy->submit(LbsRepository::CREATE_POI, $form);
        $res = json_decode($snoopy->results);
        return $res->status;
    }

    public static function updatePOI($model) {
        $snoopy = App::make('Snoopy');
        $snoopy->agent = LbsRepository::AGENT;
        $form['ak'] = LbsRepository::BAIDU_AK;
        $form['geotable_id'] = LbsRepository::GEOTABLE_ID;
        $form['latitude'] = $model['lat'];
        $form['longitude'] = $model['lng'];
        $form['coord_type'] = '3';
        $form['mid'] = $model['mid'];
        $form['mtype'] = $model['mtype'];
        $snoopy->submit(LbsRepository::UPDATE_POI, $form);
        $res = json_decode($snoopy->results);
        return $res->status;
    }

    public static function deletePOI($model,$mtype) {
        $snoopy = App::make('Snoopy');
        $snoopy->agent = LbsRepository::AGENT;
        $form['ak'] = LbsRepository::BAIDU_AK;
        $form['geotable_id'] = LbsRepository::GEOTABLE_ID;
       // $form['title'] =(string) $model->id;
        $form['tags'] = $mtype;
        $form['is_total_del'] = 1;
        $snoopy->submit(LbsRepository::DELETE_POI, $form);
        $res = json_decode($snoopy->results,true);
        return [$form,$res];
    }

    public static function nearby($model) {
        $snoopy = App::make('Snoopy');
        $snoopy->agent = LbsRepository::AGENT;
        $url = LbsRepository::NEARBY_POI
                . '?ak=' . LbsRepository::BAIDU_AK
                . '&geotable_id=' . LbsRepository::GEOTABLE_ID
                . '&location=' . $model['lat'] . ',' . $model['lng']
                . '&sortby=distance:1'
                . '&tags=' . $model['mtype'];
        $snoopy->fetchtext($url);
        $res = json_decode($snoopy->results);
        return $res->status;
    }

}
