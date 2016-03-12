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
        return $this->order(array('lft asc'))->select();
    }

    /**
     * 添加分类并计算层级,左右节点
     * @return bool
     */
    public function addCategory(){
//        var_dump($this->data);
//        exit;
        $db=D('DbMysql','Logic');    //实例化数据操作类具体执行sql语句
        $table_name=$this->trueTableName;
        //用于生成sql结构对象
        $nested_sets=new \Admin\Service\NestedSetsService($db,$table_name,
            'lft','rght','parent_id','id','level');
        if($nested_sets->insert($this->data['parent_id'],$this->data,'bottom')===false){
            $this->error='新建分类失败';
            return false;
        }
        return true;
    }
}