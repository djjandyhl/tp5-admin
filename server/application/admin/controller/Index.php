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
        $nodesArr = Node::all();
        $nodes = prepareMenu($nodesArr);
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
