<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

class RoleController extends \Think\Controller {

    private $_model = null;

    protected function _initialize() {
        $meta_titles  = array(
            'index'  => '角色管理',
            'add'    => '添加角色',
            'edit'   => '修改角色',
            'delete' => '删除角色',
        );
        $meta_title   = isset($meta_titles[ACTION_NAME]) ? $meta_titles[ACTION_NAME] : '角色管理';
        $this->assign('meta_title', $meta_title);
        $this->_model = D('Role'); //由于所有的操作都需要用到模型,我们在初始化方法中创建
    }

    /**
     * 展示角色列表
     */
    public function index() {
        $cond = array();
        $keyword = I('get.keyword');
        if($keyword){
            $cond['name'] = array('like','%'.$keyword.'%');
        }
        $this->assign('rows', $this->_model->getList($cond));
        $this->display();
    }

    /**
     * 添加权限
     */
    public function add() {
        if (IS_POST) {
            if ($this->_model->create() === false) {
                $this->error($this->_model->getError());
            }
            if ($this->_model->addRole() === false) {
                $this->error($this->_model->getError());
            }

            $this->success('添加角色成功', U('index'));
        } else {
            $this->_before_view();
            $this->display();
        }
    }

    /**
     * 修改角色
     * @param integer $id
     */
    public function edit($id) {
        if (IS_POST) {
            if ($this->_model->create() === false) {
                $this->error($this->_model->getError());
            }
            if ($this->_model->updateRole() === false) {
                $this->error($this->_model->getError());
            }

            $this->success('编辑角色成功', U('index'));
        } else {

            $this->_before_view();
            $this->assign('row', $this->_model->getRole($id));
            $this->display('add');
        }
    }

    public function delete($id) {
        if($this->_model->deleteRole($id) === false){
            $this->error($this->_model->getError());
        }
        $this->success('删除角色成功', U('index'));
    }

    private function _before_view() {
        //展示现有权限列表
        $rows = D('Permission')->getList();
        $this->assign('rows', json_encode($rows));
    }

}
