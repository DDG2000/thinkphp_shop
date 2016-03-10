<?php
/**
 * Created by PhpStorm.
 * User: 孙歆雁1
 * Date: 2016/3/11
 * Time: 0:04
 */

namespace Admin\Model;


class GoodsCategoryModel extends \Think\Model
{
    public function getList(){
        return $this->select();
    }
}