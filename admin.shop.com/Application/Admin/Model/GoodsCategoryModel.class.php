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
        $cond=array(
          'status'=>array('gt',-1),
        );
        return $this->where($cond)->order(array('lft asc'))->select();
    }

    /**
     * 添加分类并计算层级,左右节点
     * @return bool
     */
    public function addCategory(){
        $cond=array(
            'parent_id'=>$this->data['parent_id'],
            'name'=>$this->data['name'],
            'id'=>array('neq',$this->data['id']),
        );
        if($this->where($cond)->count()){
            $this->error='指定分类下已经存在同名分类';
            return false;
        }
        unset($this->data['id']);
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

    public function updateCategory(){
        $cond=array(
            'parent_id'=>$this->data['parent_id'],
            'name'=>$this->data['name'],
        );
        if($this->where($cond)->count()){
            $this->error='指定分类下已经存在同名分类';
            return false;
        }
        $request_data=$this->data;
        $db=D('DbMysql','Logic');    //实例化数据操作类具体执行sql语句
        $table_name=$this->trueTableName;
        //用于生成sql结构对象
        $nested_sets=new \Admin\Service\NestedSetsService($db,$table_name,
            'lft','rght','parent_id','id','level');
        if($nested_sets->moveUnder($request_data['id'],$request_data['parent_id'],'bottom')===false){
            $this->error='更新分类失败';
            return false;
        }
        return true;
    }
    //物理删除,并重新机选左右节点
    public function deleteCategory($id){
//        $db=D('DbMysql','Logic');    //实例化数据操作类具体执行sql语句
//        $table_name=$this->trueTableName;
//        //用于生成sql结构对象
//        $nested_sets=new \Admin\Service\NestedSetsService($db,$table_name,
//            'lft','rght','parent_id','id','level');
//        if($nested_sets->delete($id)===false){
//            $this->error='更新分类失败';
//            return false;
//        }
//        return true;


        //逻辑删除
        //将所有的后代节点及自身找出来,并更改
        $row=$this->field('lft,rght')->find($id);
        $data=array(
            'status'=>-1,
            'name'=>array('exp','concat(name,"_del")'),
        );
        $cond=array(
            'lft'=>array('egt',$row['lft']),
            'rght'=>array('elt',$row['rght']),
        );
       return $this->where($cond)->save($data);
    }
}