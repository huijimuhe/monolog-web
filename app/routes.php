  
<?php

/* * ************************
 *  HOME ROUTE
 * ************************ */
Route::get('/', ['as' => 'test', 'uses' => 'ShareController@index']);
Route::get('test', ['as' => 'test', 'uses' => 'HomeController@test']);
Route::get('install', ['as' => 'install', 'uses' => 'HomeController@install']);

/* * ************************
 *  Route patterns
 * ************************ */

Route::pattern('id', '[0-9a-z]+');
Route::pattern('user_id', '[0-9a-z]+');
Route::pattern('type', '(right)?(miss)?');
Route::pattern('page', '[0-9]+');
Route::pattern('count', '[0-9]+');

/* * ************************
 *  Auth Route
 * ************************ */
Route::get('login', [ 'as' => 'login', 'uses' => 'AuthController@getlogin']);
Route::post('login', 'AuthController@postLogin');
Route::get('logout', [ 'as' => 'logout', 'uses' => 'AuthController@getlogout']);
Route::get('user-banned', [ 'as' => 'user-banned', 'uses' => 'AuthController@userBanned']);


/* * ************************
 *  Share Route
 * ************************ */
//Route::get('shares/{id}', ['as' => 'shares.statue', 'uses' => 'StatuesController@getShare']);
/**   获取图片上传token   */


/* * ************************
 *  Admin Route 
 * ************************ */
Route::group([ 'before' => 'auth'], function() {

    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'HomeController@dashBoard']);

    Route::resource('statues', 'StatuesController');
    Route::get('hotmap', ['as' => 'statues.hotmap', 'uses' => 'StatuesController@getHotMap']);
    Route::post('statue/mulitDelete', ['as' => 'statues.mulitDelete', 'uses' => 'StatuesController@postMulitDelete']);

    Route::resource('users', 'UsersController');
    Route::get('users/show/{user_id}/{user_show_type?}', ['as' => 'users.show', 'uses' => 'UsersController@show']);

    Route::get('entrust', ['as' => 'roles.index', 'uses' => 'UsersController@roleIndex']);
    Route::get('entrust/role/show/{id}', ['as' => 'roles.show', 'uses' => 'UsersController@getRolePerm']);
    Route::post('entrust/role/create', ['as' => 'roles.createRole', 'uses' => 'UsersController@postCreateRole']);
    Route::post('entrust/perm/create', ['as' => 'roles.createPerm', 'uses' => 'UsersController@postCreatePerm']);

    Route::get('reports', ['as' => 'reports.index', 'uses' => 'ReportsController@index']);
    Route::post('reports/deal/{id}', ['as' => 'reports.deal', 'uses' => 'ReportsController@postDeal']);

    Route::resource('settings', 'SettingsController');
    Route::post('settings/mulitDelete', ['as' => 'settings.mulitDelete', 'uses' => 'SettingsController@postMulitDelete']);
    /**     * ***********************
     *   entrust initiation Route 
     * ************************ */
//    Route::get('entrust/love', 'AuthController@setupFoundorAndBaseRolsPermission');
});


/* * ************************
 *  JSON Route 
 * ************************ */
Route::group(['prefix' => 'api'], function() {
    Route::get('agreement', [ 'uses' => 'SettingsController@getAgreement']); 
    Route::post('open', ['uses' => 'ApiAuthController@postSignIn']);
});

Route::group(['prefix' => 'api', 'before' => 'ApiAuth'], function() { 
    
    Route::get('token', ['as' => 'oss.token', 'uses' => 'StatuesController@getOssToken']);
    
    /*     * ***********************
     *  STATUE ROUTES   
     * ************************ */
    Route::get('statue', ['uses' => 'ApiStatuesController@getStatue']);
    Route::get('mystatues/{page?}', ['uses' => 'ApiStatuesController@getMyStatues']);
    Route::get('userstatues/{page?}', ['uses' => 'ApiStatuesController@getUserStatues']);
    Route::get('myguess/{type}/{page?}', ['uses' => 'ApiStatuesController@getMyGuess']);
    Route::get('osstoken', ['uses' => 'ApiStatuesController@getOssToken']);
    Route::post('guess', ['uses' => 'ApiStatuesController@postGuess']);
    Route::post('statue/create', ['uses' => 'ApiStatuesController@postCreate']);
    Route::post('statue/destory', ['uses' => 'ApiStatuesController@postDestory']);

    /*     * ***********************
     *  AUTH ROUTES    
     * ************************ */
    Route::post('signout', ['uses' => 'ApiAuthController@postSignout']);
    Route::post('avatar', ['uses' => 'ApiAuthController@postChangeAvatar']);
    Route::post('changeprofile', ['uses' => 'ApiAuthController@postChangeProfile']);
    Route::post('changepwd', ['uses' => 'ApiAuthController@postChangePwd']);
    Route::get('profile', ['uses' => 'ApiAuthController@getProfile']);

    /*     * ************************
     *  follow/fan Route
     * ************************ */
    Route::get('contacts', ['uses' => 'ApiContactsController@getContacts']);
    Route::get('contact', ['uses' => 'ApiContactsController@getContact']);
    /*     * ***********************
     *  NOTIFICATION ROUTES   
     * ************************ */
    Route::get('notify/unread_count', ['uses' => 'ApiNotificationsController@getUnReadCount']);

    /*     * ************************
     *  REPORT Route
     * ************************ */
    Route::post('report', ['uses' => 'ApiReportsController@postReport']);
});
