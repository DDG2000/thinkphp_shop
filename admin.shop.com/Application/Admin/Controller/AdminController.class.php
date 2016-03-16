<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

/**
 * Description of AdminController
 *
 * @author qingf
 */
class AdminController extends \Think\Controller {

    private $_model = null;

    protected function _initialize() {
        $meta_titles  = array(
            'index'  => '管理员管理',
            'add'    => '添加管理员',
            'edit'   => '修改管理员',
            'delete' => '删除管理员',
        );
        $meta_title   = isset($meta_titles[ACTION_NAME]) ? $meta_titles[ACTION_NAME] : '管理员管理';
        $this->assign('meta_title', $meta_title);
        $this->_model = D('Admin'); //由于所有的操作都需要用到模型,我们在初始化方法中创建
    }

    /**
     * 管理员列表
     */
    public function index() {
        $keyword = I('get.keyword');
        $cond    = array();
        if ($keyword) {
            $cond['username'] = array('like', '%' . $keyword . '%');
        }

        $this->assign($this->_model->getPageResult($cond, I('get.p')));
        $this->display();
    }

    /**
     * 添加管理员
     */
    public function add() {
        if (IS_POST) {
            if ($this->_model->create() === false) {
                $this->error($this->_model->getError());
            }
            if ($this->_model->addAdmin() === false) {
                $this->error($this->_model->getError());
            }

            $this->success('添加管理员成功', U('index'));
        } else {
            $this->_before_view();
            $this->display();
        }
    }

    /**
     * 修改管理员
     * @param type $id
     */
    public function edit($id) {
        if (IS_POST) {
            if ($this->_model->create() === false) {
                $this->error($this->_model->getError());
            }
            if ($this->_model->updateAdmin() === false) {
                $this->error($this->_model->getError());
            }

            $this->success('修改管理员成功', U('index'));
        } else {
            $this->_before_view();
            $this->assign('row', $this->_model->getAdminInfo($id));
            $this->display('add');
        }
    }

    public function delete($id) {
        if ($this->_model->deleteAdmin($id) === false) {
            $this->error($this->_model->getError());
        }

        $this->success('删除管理员成功', U('index'));
    }

    /**
     * 获取角色和权限列表
     */
    private function _before_view() {
        //展示所有的角色列表
        $rows = D('Role')->getList();
        $this->assign('roles', $rows);
        //展示所有的权限列表
        $rows = D('Permission')->getList();
        $this->assign('permissions', json_encode($rows));
    }

}
