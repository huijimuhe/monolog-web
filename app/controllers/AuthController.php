<?php

class AuthController extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    public function getlogin() {
        return View::make('auth.login');
    }

    public function getlogout() {
        Auth::logout();
        return Redirect::route('login');
    }

    public function postLogin() {
        $credentials = [
            'phone' => Input::get('phone'),
            'password' => Input::get('password')
        ];
        $validator = Validator::make(Input::all(), [
                    'phone' => 'required',
                    'password' => 'required|min:6|unique:users|alpha_dash',
        ]);
        if ($validator->fails()) {
            Flash::error($validator->messages()->first());
            return Redirect::back()->withInput();
        }
        if (Auth::attempt($credentials)) {
            return Redirect::route('dashboard');
        } else {
            Flash::error('用户名或密码错误');
            return Redirect::back()->withInput();
        }
    }

    /**
     * 权限初始化
     * GET /users/create
     *
     * @return Response
     */
    public function setupFoundorAndBaseRolsPermission() {
        // Create Roles
        $founder = new Role;
        $founder->name = 'admin';
        $founder->save();

        // Create User
        $user = User::where('phone', '=', '110')->first();

        // Attach Roles to user
        $user->roles()->attach($founder->id);

        // Create Permissions
        $manage = new Permission;
        $manage->name = 'admin';
        $manage->display_name = 'administrator';
        $manage->save();

        // Assign Permission to Role
        $founder->perms()->sync([$manage->id]);

        echo "done";
    }

    /**
     * 权限管理
     * GET /users/create
     *
     * @return Response
     */
    public function getPers() {
        return View::make('auth.pers');
    }

}
