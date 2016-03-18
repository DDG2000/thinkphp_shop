<?php

namespace Admin\Model;

class MenuModel extends \Think\Model {

    //自动验证
    protected $_validate = array(
        array('name', 'require', '菜单名称不能为空', self::EXISTS_VALIDATE, '', self::MODEL_BOTH),
        array('parent_id', 'require', '父级菜单不能为空', self::EXISTS_VALIDATE, '', self::MODEL_BOTH),
    );

    /**
     * 添加菜单,使用nestedsets
     * 由于是新增菜单,所以直接调用nestedsets的insert即可
     */
    public function addMenu() {
        //去掉id,新建菜单不需要id
        unset($this->data['id']);
        //开启事务
        $this->startTrans();
        //netedsets插入数据
        $db_mysql    = D('DbMysql', 'Logic');
        $table_name  = $this->trueTableName;
        $nested_sets = new \Admin\Service\NestedSetsService($db_mysql,
            $table_name, 'lft', 'rght', 'parent_id', 'id', 'level');
        if (($menu_id=$nested_sets->insert($this->data['parent_id'],
                $this->data, 'bottom'))=== false) {
            $this->error = '添加菜单失败';
            $this->roolback();
            return false;
        }
        if($this->_addPermission($menu_id)===false){
            $this->error='保存菜单关系失败';
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }

    /**添加菜单菜单对应关系
     * @param $menu_id
     * @return bool
     */
    public function _addPermission($menu_id){
        //获取保存的菜单id
        $permission_ids=I('post.permission_id');
        //如果没有传入permission_id,直接返回true
        if(!$permission_ids){
//            echo 111;
            return true;
        }
        //生成要插入的数据,二维数组
        $data=array();
        foreach($permission_ids as $permission_id){
            $data[]=array(
                'menu_id'=>$menu_id,
                'permission_id'=>$permission_id,
            );
        }

       return $rst = M('MenuPermission')->addAll($data);
//        var_dump($rst);
//        exit;
    }

    /**
     * 获取菜单列表
     * @return type
     */
    public function getList() {
        $cond = array('status' => array('gt', 0));
        return $this->where($cond)->select();
    }

    /**删除原有的权限
     * @param $menu_id
     * @return mixed
     */
    public function _deletePermission($menu_id){
//        dump(M('MenuPermission')->select());
        return M('MenuPermission')->where(array('menu_id'=>$menu_id))->delete();
        }

    /**
     * 修改菜单.
     * @return boolean
     */
    public function updateMenu() {
        //开启事务
        $this->startTrans();
        //获取原来的父级节点
        $request_data = $this->data;
        //编辑分类的时候判断指定的父级分类下有没有同名分类
        $cond         = array(
            'parent_id' => $request_data['parent_id'],
            'name'      => $request_data['name'],
            'id'        => array('neq', $request_data['id']),);
        if ($this->where($cond)->count()) {
            $this->error = '已经存在同名菜单';
            $this->rollback();
            return false;}
        //删除权限
        if ($this->_deletePermission($request_data['id'])===false) {
            $this->error = '删除菜单失败';
            $this->rollback();
            return false;}
        //添加权限
        if ($this->_addPermission($request_data['id'])===false) {
            $this->error = '添加菜单失败';
            $this->rollback();
            return false;
        }


        //修改菜单表
        $old_parent_id = $this->getFieldById($request_data['id'], 'parent_id');
        //由于如果没有改变父级分类,moveUnder将会返回false,所以我们先判断是否改变了父级分类
        if ($old_parent_id !== $request_data['parent_id']) {
            //创建具体的sql执行的对象
            $db          = D('DbMysql', 'Logic');
            $table_name  = $this->trueTableName; //获取数据表的名字
            //创建用于生成sql结构的对象
            $nested_sets = new \Admin\Service\NestedSetsService($db, $table_name,
                'lft', 'rght', 'parent_id', 'id', 'level');
            if ($nested_sets->moveUnder($request_data['id'], $request_data['parent_id'],
                    'bottom') === false) {
                $this->error = '修改父级菜单失败';
                $this->rollback();
                return false;
            }
        }
        //保存基本信息
        if ($this->save() === false) {
            $this->error = '修改菜单失败';
            $this->rollback();
            return false;
        }

        $this->commit();
        return true;
    }
    
    /**
     * 逻辑删除菜单,同时会删除所有的后代菜单
     * @param integer $id
     * @return interger|false
     */
    public function deleteMenu($id){
        $row = $this->field('lft,rght')->find($id);
        //update goods_category set status=-1 where lft>=17 and rght<=25
        $data = array(
            'status'=>0,
            'name'=>array('exp','concat(`name`,"_del")'),
        );
        //拼接条件,所有的后代分类左节点都>当前的左节点,所有的右节点都<当前的右节点
        $cond = array(
            'lft'=>array('egt',$row['lft']),
            'rght'=>array('elt',$row['rght']),
        );
        return $this->where($cond)->save($data);
    }

    /**获取菜单详细信息,包括所拥有的菜单
     * @param $menu_idhuo
     */
    public function getMenuInfo($menu_id){
        //基本信息
        $row=$this->find($menu_id);
        //权限信息
        if($row){
            $row['permission_id']=json_encode(M('MenuPermission')->
            where(array('menu_id'=>$menu_id))->getField('permission_id', true));
        }
        return $row;
    }

    //获取当前管理员可见的菜单
    public function getAdminMenu(){
        //取出所有的菜单列表
        $pids=pids();
        if(!$pids){
            return array();
        }
        $cond=array(
            'mp.permission_id'=>array('in',$pids),
            'status'=>array('gt',0),
        );

        $rows= $this->field('distinct id,name,level,parent_id,url')->alias('as m')->join('left join __MENU_PERMISSION__ as mp on m.id=mp.menu_id')->where($cond)->select();
        return $rows;
    }


}
