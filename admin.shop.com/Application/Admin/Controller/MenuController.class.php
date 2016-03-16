<?php

namespace Admin\Controller;

class MenuController extends \Think\Controller {

    private $_model = null;

    protected function _initialize() {
        $meta_titles  = array(
            'index'  => '菜单管理',
            'add'    => '添加菜单',
            'edit'   => '修改菜单',
            'delete' => '删除菜单',
        );
        $meta_title   = isset($meta_titles[ACTION_NAME]) ? $meta_titles[ACTION_NAME] : '菜单管理';
        $this->assign('meta_title', $meta_title);
        $this->_model = D('Menu'); //由于所有的操作都需要用到模型,我们在初始化方法中创建
    }

    /**
     * 菜单列表页
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
            if ($this->_model->addMenu() === false) {
                $this->error($this->_model->getError());
            }

            $this->success('添加菜单成功', U('index'));
        } else {
            $this->_before_view();
            $this->display();
        }
    }

    /**
     * 编辑菜单
     * @param integer $id
     */
    public function edit($id) {
        if (IS_POST) {
            if ($this->_model->create() === false) {
                $this->error($this->_model->getError());
            }
            if ($this->_model->updateMenu() === false) {
                $this->error($this->_model->getError());
            }

            $this->success('修改菜单成功', U('index'));
        } else {
            $this->_before_view();
            $this->assign('row',$this->_model->getMenuInfo($id));
            $this->display('add');
        }
    }

    /**
     * 获取菜单列表,以便ztree生成树
     */
    private function _before_view() {
        //展示现有菜单列表
        $rows     = $this->_model->getList();
        $top_node = array(
            'id'        => 0,
            'name'      => '请选择',
            'parent_id' => '',
        );
        array_unshift($rows, $top_node);
//        dump($rows);
        $this->assign('rows', json_encode($rows));
        $permissions = D('Permission')->getList();
        $this->assign('permissions', json_encode($permissions));
    }
    
    
    /**
     * 删除菜单
     * @param type $id
     */
    public function delete($id){
        if($this->_model->deleteMenu($id)===false){
            $this->error('删除菜单失败');
        }
        $this->success('删除菜单成功',U('index'));
    }


}
