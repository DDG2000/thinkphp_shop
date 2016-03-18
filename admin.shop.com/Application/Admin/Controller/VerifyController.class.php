<?php
/**
 * Created by PhpStorm.
 * User: 孙歆雁1
 * Date: 2016/3/16
 * Time: 23:28
 */

namespace Admin\Controller;


class VerifyController extends \Think\Controller
{

    public function verify(){
    $config=array(
        'length'=>4,
    );
        $verify=new \Think\Verify($config);
        $verify->entry();
}
}