<?php
/**
 * Created by PhpStorm.
 * User: 孙歆雁1
 * Date: 2016/3/7
 * Time: 17:46
 */

namespace Admin\Controller;


class SupplierController extends \Think\Controller
{
    private $_model=null;
    protected function _initialize(){
    //标题数组
    $meta_title=array(
        'index'=>'供货商管理',
        'add'=>'添加供货商',
        'edit'=>'编辑供货商',
        'delete'=>'删除供货商',
    );
    //方法不在数组中，默认为供货商管理
    $meta_title=isset($meta_title[ACTION_NAME])?$meta_title[ACTION_NAME]:'供货商管理';
    $this->assign('meta_title',$meta_title);
    $this->_model=D('Supplier');
    }

    public function index(){
    //    $model=D('Supplier');
        $this->assign('rows',$this->_model->select());
        $this->display();
    }
    public function add(){
        if(IS_POST){
            //收集数据验证数据是否合法
            if($this->_model->create()===false){
                $this->error($this->_model->getError());
            }
            if($this->_model->add()===false){
                $this->error($this->_model->getError());
            }
            $this->success('添加成功',U('index'));
        }else{
            $this->display();
        }
    }

    //供货商的修改
    public function edit($id){
        if(IS_POST){
            if($this->_model->create()===false){
                $this->error($this->_model->getError());
            }
            //执行保存操作失败
            if($this->_model->save()===false){
                $this->error($this->_model->getError());
            }
            $this->success('修改成功',U('index'));
        }else{
            //展示数据表中的数据
            $row=$this->_model->find($id);
            $this->assign('row',$row);
            $this->display('add');
        }
    }
}