<?php

namespace Common\Behaviors;
class CheckPermissionBehavior extends \Think\Behavior
{
    public function run(&$params){
        //自动登录获取用户的权限列表
        D('Admin')->autoLogin();
        $paths=paths();
        $ignore=C('ACCESS_ACTION');
        $paths=array_merge($ignore,$paths);

        //当前路径
        $path=MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
        //判断当前路径是否在有权限的路径中
        if(in_array($path,$paths)){
            return true;
        }else{
            redirect(U('Admin/login'),1,'权限不足');
        }
    }
}