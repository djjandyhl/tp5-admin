<?php
namespace app\admin\behavior;

class ReposeCrossAjax
{
    public function run(&$params)
    {
        if($params){
            header('Access-Control-Allow-Headers:  Content-Type,Authorization');
        }
    }
}