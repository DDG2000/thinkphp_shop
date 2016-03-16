<?php

namespace Admin\Controller;

class PermissionController extends \Think\Controller {

    private $_model = null;

    protected function _initialize() {
        $meta_titles  = array(
            'index'  => '权限管理',
            'add'    => '添加权限',
            'edit'   => '修改权限',
            'delete' => '删除权限',
        );
        $meta_title   = isset($meta_titles[ACTION_NAME]) ? $meta_titles[ACTION_NAME] : '权限管理';
        $this->assign('meta_title', $meta_title);
        $this->_model = D('Permission'); //由于所有的操作都需要用到模型,我们在初始化方法中创建
    }

    /**
     * 权限列表页
     */
    public function index() {
        $this->assign('rows', $this->_model->getList());
        $this->display();
    }

    public function add() {
        if (IS_POST) {
            if ($this->_model->create() === false) {
                $this->error($this->_model->getError());
            }
            if ($this->_model->addPermission() === false) {
                $this->error($this->_model->getError());
            }

            $this->success('添加权限成功', U('index'));
        } else {
            $this->_before_view();
            $this->display();
        }
    }

    /**
     * 编辑权限
     * @param integer $id
     */
    public function edit($id) {
        if (IS_POST) {
            if ($this->_model->create() === false) {
                $this->error($this->_model->getError());
            }
            if ($this->_model->updatePermission() === false) {
                $this->error($this->_model->getError());
            }

            $this->success('修改权限成功', U('index'));
        } else {
            $this->_before_view();
            $this->assign('row',$this->_model->find($id));
            $this->display('add');
        }
    }

    /**
     * 获取权限列表,以便ztree生成树
     */
    private function _before_view() {
        //展示现有权限列表
        $rows     = $this->_model->getList();
        $top_node = array(
            'id'        => 0,
            'name'      => '请选择',
            'parent_id' => '',
        );
        array_unshift($rows, $top_node);
//        dump($rows);
        $this->assign('rows', json_encode($rows));
    }
    
    
    /**
     * 删除权限
     * @param type $id
     */
    public function delete($id){
        if($this->_model->deletePermission($id)===false){
            $this->error('删除权限失败');
        }
        $this->success('删除权限成功',U('index'));
    }


}
