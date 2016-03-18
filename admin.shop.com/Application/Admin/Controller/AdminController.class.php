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
            'resetPwd' => '重置管理员密码',
            'updatePwd' => '修改管理员密码',
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

    /**
     * 后台管理员登录
     */
    public function login(){
        if(IS_POST){
            if (($userinfo=$this->_model->login()) === false) {
                $this->error($this->_model->getError());
            }
            //将用户的信息保存到seesion中,抽到函数里>>2保存用户信息到session
            login($userinfo);

            //将用户的权限列表存放到列表中
            $this->_model->setPermissionsToSession();
            //取出菜单列表
            //获取用户权限并保存
            //判断是否要自动登陆
            if(I('post.remember')){
                //保存在cookie和数据表中
                $data = array(
                    'admin_id'=>$userinfo['id'],
                    'token'=>  createToken(),
                );
                //存到数据表中>>3保存用户id和token到admin_token表中
                M('AdminToken')->add($data);
                //保存到cookie>>4保存到cookie中
                token($data);
            }else{
                //删除token
                cookie('token',null);
                $cond = array(
                    'admin_id'=>$userinfo['id'],
                );
                M('AdminToken')->where($cond)->delete();
            }
            $this->success('登录成功', U('Index/index'));
        }else{
            $this->display();
        }
    }

    /**
     * 后台退出
     */
    public function logout(){
        $userinfo = login();
        $admin_id = $userinfo['id'];
        //删除token数据表中当前用户的数据
        M('AdminToken')->where(array('admin_id'=>$admin_id))->delete();
        //删除cookie中用户的数据
        cookie('token',null);
        session(null);
        //删除session
        $this->success('退出成功',U('login'));
    }

    /**
     * 重置用户的密码
     */
    public function resetPwd($id){
        if(IS_POST){
            if ($this->_model->create() === false) {
                $this->error($this->_model->getError());
            }
            if ($this->_model->resetPwd() === false) {
                $this->error($this->_model->getError());
            }

            $this->success('重置密码成功', U('index'));
        }else{
        $row=$this->_model->find($id);
        $row['password']=\Org\Util\String::randString(6);
        $this->assign('row',$row);
        $this->display();

        }
    }

    public function updatePwd(){
        if(IS_POST){
            if ($this->_model->create('',5) === false) {
                $this->error($this->_model->getError());
            }
            if ($this->_model->updatePwd() === false) {
                $this->error($this->_model->getError());
            }

            $this->success('修改密码成功', U('index'));
        }else {
            $userinfo = login();
            $id = $userinfo['id'];
            $row = $this->_model->find($id);
            $row['password'] = \Org\Util\String::randString(6);
            $this->assign('row', $row);
            $this->display();
        }
    }
}
