<?php
// +----------------------------------------------------------------------
// | snake
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2022 http://baiyf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: NickBai <1902822973@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\Role;
use think\Cache;
use think\Controller;
use org\Verify;

class Login extends Controller
{
    //登录页面
    public function index()
    {
        return $this->fetch('/login');
    }

    //登录操作
    public function doLogin()
    {
        $username = input("param.username");
        $password = input("param.password");
        $result = $this->validate(compact('username', 'password'), 'AdminValidate');
        if (true !== $result) {
            return json(['code' => -5, 'data' => '', 'msg' => $result]);
        }

        $hasUser = db('user')->field("id,username,password,status,real_name,role_id,loginnum")->where('username', $username)->find();
        if (empty($hasUser)) {
            return json(['code' => -1, 'data' => '', 'msg' => '管理员不存在']);
        }

        if (md5($password) != $hasUser['password']) {
            return json(['code' => -2, 'data' => '', 'msg' => '密码错误']);
        }

        if (1 != $hasUser['status']) {
            return json(['code' => -6, 'data' => '', 'msg' => '该账号被禁用']);
        }

        //获取该管理员的角色信息
        $user = new Role();
        $info = $user->getRoleInfo($hasUser['role_id']);
        //更新管理员状态
        $param = [
            'loginnum' => $hasUser['loginnum'] + 1,
            'last_login_ip' => request()->ip(),
            'last_login_time' => time(),
            'jwt_token' => uniqid()
        ];
        $info['username'] = $hasUser['username'];
        $info['realname'] = $hasUser['real_name'];
        $info['id'] = $hasUser['id'];
        $info['roleId'] = $hasUser['role_id'];
        Cache::set($param['jwt_token'],$info);

        db('user')->where('id', $hasUser['id'])->update($param);
        return json(['code' => 1, 'data' => $param['jwt_token'], 'msg' => '登录成功']);
    }

    //验证码
    public function checkVerify()
    {
        $verify = new Verify();
        $verify->imageH = 36;
        $verify->imageW = 130;
        $verify->length = 4;
        $verify->useNoise = false;
        $verify->fontSize = 16;
        return $verify->entry();
    }

    //退出操作
    public function logout()
    {
        $requestHeaders = apache_request_headers() ;
        $auth = $requestHeaders['Authorization'];
        if(!empty($auth)){
            Cache::rm($auth);
        }
        return json(['msg'=>'退出成功','status'=>1]);
    }
}