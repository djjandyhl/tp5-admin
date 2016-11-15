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
use think\Db;
use org\Tree;
class Index extends Base
{
    public function index()
    {
        //获取权限菜单
        $node = new Node();
        $menus = $node->getMenu($this->admin['rule']);
        return $this->returnJson(['menus'=>$menus,'info'=>$this->admin]);
    }
    public function nodes()
    {
        $nodesArr = Db::table('node')->field('id,node_name,parent_id as parentid')->select();
        $tree = new Tree();
        $tree->init($nodesArr);
        $nodes = $tree->get_tree_array_nokey();
        return $this->returnJson($nodes);
    }
    /**
     * 后台默认首页
     * @return mixed
     */
    public function indexPage()
    {
        return $this->fetch('index');
    }
}
