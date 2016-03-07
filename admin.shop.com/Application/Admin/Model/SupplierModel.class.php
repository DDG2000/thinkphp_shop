<?php
/**
 * Created by PhpStorm.
 * User: 孙歆雁1
 * Date: 2016/3/7
 * Time: 17:47
 */

namespace Admin\Model;


class SupplierModel extends \Think\Model
{
    //自动验证
    protected $_validate=array(
        array('name','require','供货商名字不能为空'),
        array('name','','供货商名字一存在',self::EXISTS_VALIDATE,'unique'),
    );

    //数据插入
    public function addSupplier(){

    }
}