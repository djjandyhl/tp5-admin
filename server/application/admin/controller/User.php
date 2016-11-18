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


use app\admin\Model\User as UserModel;
use think\Cache;

class User extends Base
{
    //用户列表
    public function index()
    {


        $param = input('param.');

        $limit = $param['pageSize'];
        $offset = ($param['pageNumber'] - 1) * $limit;

        $where = [];
        if (isset($param['searchText']) && !empty($param['searchText'])) {
            $where['username'] = ['like', '%' . $param['searchText'] . '%'];
        }
        if (isset($param['roleId']) && $param['roleId'] > 0) {
            $where['role_id'] = ['eq', $param['roleId']];
        }
        $user = new UserModel();
        $selectResult = $user->getUsersByWhere($where, $offset, $limit);

        $status = config('user_status');

        foreach ($selectResult as $key => $vo) {
            $selectResult[$key]['last_login_time'] = $vo['last_login_time']?date('Y-m-d H:i:s', $vo['last_login_time']):'';
            $selectResult[$key]['status'] = $status[$vo['status']];
        }

        $return['total'] = $user->getAllUsers($where);  //总数据
        $return['rows'] = $selectResult;

        return json($return);
    }

    //添加用户
    public function userAdd()
    {


        $param = input('post.');
        //$param = parseParams($param['data']);

        $param['password'] = md5($param['password']);
        $user = new UserModel();
        $flag = $user->insertUser($param);

        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);


    }

    //编辑角色
    public function userEdit()
    {
        $user = new UserModel();

        if (request()->isPost()) {

            $param = input('post.');
//            $param = parseParams($param['data']);
            if (empty($param['reset_password'])) {
                unset($param['reset_password']);
            } else {
                $param['password'] = md5($param['reset_password']);
                unset($param['reset_password']);
            }
            $flag = $user->editUser($param);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
    }

    //删除角色
    public function delete()
    {
        $id = input('param.id');

        $role = new UserModel();
        $flag = $role->delUser($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
}