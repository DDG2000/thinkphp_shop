<?php

namespace Common\Behaviors;

class CheckLoginBehavior extends \Think\Behavior {

    /**
     * 验证用户是否有登陆,如果没有,就判断是否有合适的token,如果有,就获取用户信息,保存到session中,并重新生成token
     * @param type $params
     */
    public function run(&$params) {
        //获取session中的值
        $userinfo = login();
        //userinfo存在,已登录过
        if ($userinfo) {
            return true;
        }
    }

}
