<?php
/**
 * Created by PhpStorm.
 * User: 孙歆雁1
 * Date: 2016/3/20
 * Time: 1:08
 */

namespace Home\Model;


class GoodsCategoryModel extends \Think\Model
{
    public function getAllCategory(){
        $cond=array(
            'status'=>array('gt',0),
            'level'=>array('elt',3),
        );
        return $this->where($cond)->select();
    }
}