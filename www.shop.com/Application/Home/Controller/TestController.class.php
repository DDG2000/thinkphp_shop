<?php
/**
 * Created by PhpStorm.
 * User: 孙歆雁1
 * Date: 2016/3/18
 * Time: 23:39
 */

namespace Home\Controller;


class TestController extends \Think\Controller
{
    public function sendSMS($telephone){

        $param=array(
             'code'=>\Org\Util\String::randNumber(1000,9999),
             'product'=>'京西商城'
        );
        if(sendSMS($telephone,$param)){
            $return=array(
                'status'=>1,
            );
        }else{
            $return=array(
                'status'=>0,
            );
        }
        $this->ajaxReturn($return);
        exit;
    }
}