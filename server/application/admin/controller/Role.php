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
        $param['rule'] = implode(",",$nodes);

        $role = new RoleModel();
        $flag = $role->insertRole($param);

        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);

    }

    //编辑角色
    public function roleEdit()
    {
        $role = new UserType();

        if (request()->isPost()) {

            $param = input('post.');
            $param = parseParams($param['data']);

            $flag = $role->editRole($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $this->assign([
            'role' => $role->getOneRole($id)
        ]);
        return $this->fetch();
    }

    //删除角色
    public function roleDel()
    {
        $id = input('param.id');

        $role = new RoleModel();
        $flag = $role->delRole($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }

    //分配权限
    public function giveAccess()
    {
        $param = input('param.');
        $node = new Node();
        //获取现在的权限
        if ('get' == $param['type']) {

            $nodeStr = $node->getNodeInfo($param['id']);
            return json(['code' => 1, 'data' => $nodeStr, 'msg' => 'success']);
        }
        //分配新权限
        if ('give' == $param['type']) {

            $doparam = [
                'id' => $param['id'],
                'rule' => $param['rule']
            ];
            $user = new UserType();
            $flag = $user->editAccess($doparam);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
    }
}