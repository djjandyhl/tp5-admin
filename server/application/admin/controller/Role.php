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
use app\admin\model\Role as RoleModel;

class Role extends Base
{
    //角色列表
    public function index()
    {

        $param = input('param.');

        $where = [];
        if (isset($param['searchText']) && !empty($param['searchText'])) {
            $where['rolename'] = ['like', '%' . $param['searchText'] . '%'];
        }
        $model = new RoleModel();
        $selectResult = $model->getRoleByWhere($where);
        $return['total'] = $model->getAllRole($where);  //总数据
        $return['rows'] = $selectResult;

        return json($return);
    }

    //添加角色
    public function roleAdd()
    {
        $param['rolename'] = input('post.rolename');
        $nodes = input('post.nodes/a');
        $param['rule'] = implode(",", $nodes);

        $role = new RoleModel();
        $flag = $role->insertRole($param);

        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);

    }

    //编辑角色
    public function roleEdit()
    {
        $role = new RoleModel();
        $param['rolename'] = input('post.rolename');
        $nodes = input('post.nodes/a');
        $param['rule'] = implode(",", $nodes);
        $param['id'] = input('post.id/d');
        $flag = $role->editRole($param);

        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }

    //删除角色
    public function roleDel()
    {
        $id = input('param.id');

        $role = new RoleModel();
        $flag = $role->delRole($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
}