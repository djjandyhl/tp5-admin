<?php
namespace app\admin\behavior;

use think\Request;

class ReposeCrossAjax
{
    public function run(&$params)
    {
        $request = new Request();
        $method = $request->method();
        if($method == "OPTIONS"){
            exit();
        }
    }
}