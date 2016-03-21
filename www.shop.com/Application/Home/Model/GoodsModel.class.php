<?php
/**
 * Created by PhpStorm.
 * User: 孙歆雁1
 * Date: 2016/3/20
 * Time: 15:34
 */

namespace Home\Model;


class GoodsModel extends \Think\Model
{
    public function getGoodsByStatus($status,$limit=5){
        $cond=array(
            'status'=>array('gt',0),
            'goods_status&'.$status,
        );
        return $this->where($cond)->limit($limit)->order('sort')->select();
    }
    public function getGoodsInfo($goods_id){
        $cond = array(
            'status'=>1,
        );
        $row= $this->where($cond)->find($goods_id);
        $row['brand_name'] = M('Brand')->getFieldById($row['brand_id'],'name');
        $row['content'] = M('GoodsIntro')->getFieldByGoodsId($goods_id,'content');
        $row['gallery'] = M('GoodsGallery')->where(array('goods_id'=>$goods_id))->getField('path',true);
//        dump($this->getLastSql());
        $row['logo'] = $row['gallery'][0];
//        dump($row['gallery']);
//        exit;
        return $row;
    }
}