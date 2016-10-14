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

use app\admin\model\Node;
use think\Cache;
use think\Controller;
use think\Db;
use think\exception\HttpResponseException;
use think\Request;
use think\Response;

class Base extends Controller
{
    protected $request;
    protected $admin;
    protected $headers = ['Access-Control-Allow-Headers'=>'Content-Type,Authorization,X-Requested-With'];
    public function _initialize()
    {
        $requestHeaders = apache_request_headers() ;
        $auth = $requestHeaders['Authorization'];
        if(empty($auth)){
            $this->returnJson('','未登录',-1);
        }
        $this->admin = Cache::get($auth);//Db::table('user')->where('jwt_token',$auth)->find();
        if(!$this->admin){
            $this->returnJson('','错误的token',-1);
        }
        //检测权限
        $control = strtolower($this->request->controller());
        $action = $this->request->action();

        //跳过登录系列的检测以及主页权限
        if(!in_array($control, ['login', 'index'])){

            if(!in_array($control . '/' . $action, $this->admin['action'])){
                $this->returnJson('','没有权限',0);
            }
        }
    }

    protected function returnJson($data='',$msg='',$status=1){
        $result = [
            'status' => $status,
            'msg'  => $msg,
            'time' => $_SERVER['REQUEST_TIME'],
            'data' => $data,
        ];
        $type     = 'json';
        $response = Response::create($result, $type)->header($this->headers);
        throw new HttpResponseException($response);
    }
}