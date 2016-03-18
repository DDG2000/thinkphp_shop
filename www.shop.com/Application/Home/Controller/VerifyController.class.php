<?php
/**
 * Created by PhpStorm.
 * User: 孙歆雁1
 * Date: 2016/3/19
 * Time: 1:26
 */

namespace Home\Controller;


class VerifyController extends \Think\Controller
{
    public function verify(){
        $cond=array(
            'length'=>4,
        );
        $verify=new \Think\Verify($cond);
        $verify->entry();
    }
}