<?php
/**
 * Created by PhpStorm.
 * User: 孙歆雁1
 * Date: 2016/3/10
 * Time: 23:53
 */

namespace Admin\Controller;


class GoodsCategoryController extends \Think\Controller
{
    private $_model = null;
    protected function _initialize()
    {
        //标题数组
        $meta_title = array(
            'index' => '分类管理',
            'add' => '添加分类',
            'edit' => '编辑分类',
            'delete' => '删除分类',
        );
        //方法不在数组中，默认为分类管理
        $meta_title = isset($meta_title[ACTION_NAME]) ? $meta_title[ACTION_NAME] : '分类管理';
        $this->assign('meta_title', $meta_title);
        $this->_model = D('GoodsCategory');
    }
    public function index(){
        $rows=$this->_model->getList();
        $this->assign('rows',$rows);
        $this->display();
    }
    public function add(){
        if(IS_POST){
            //验证数据
            if($this->_model->create()===false){
                $this->error($this->_model->getError());
            }
            //添加数据
            if($this->_model->addCategory()===false){
                $this->error($this->_model->getError());
            }
            //成功后跳转
            $this->success('添加分类成功',U('index'));
        }else{
            $this->_model=D('GoodsCategory');
            $rows=$this->_model->getList();
            $rows=json_encode($rows);
            $this->assign('rows',$rows);
            $this->display('add');
        }
    }

    public function edit($id){
        if(IS_POST){
            //验证数据
            if($this->_model->create()===false){
                $this->error($this->_model->getError());
            }
            //添加数据
            if($this->_model->updateCategory()===false){
                $this->error($this->_model->getError());
            }
            //成功后跳转
            $this->success('添加分类成功',U('index'));
        }else{
            $this->_model=D('GoodsCategory');
            $data=$this->_model->find($id);
            $rows=$this->_model->getList();
            $rows=json_encode($rows);
            $this->assign('data',$data);
            $this->assign('rows',$rows);
            $this->display('add');
        }
    }
}