<?php
/**
 * Created by PhpStorm.
 * User: 孙歆雁1
 * Date: 2016/3/13
 * Time: 14:04
 */

namespace Admin\Controller;


class GoodsController extends \Think\Controller
{
    //初始化自动完成，分派数据显示标题,实例化模型
    //自动实例化模型
    private $_model=null;
    protected function _initialize(){
        //标题数组
        $meta_title=array(
            'index'=>'商品管理',
            'add'=>'添加商品',
            'edit'=>'编辑商品',
            'delete'=>'删除商品',
        );
        //方法不在数组中，默认为商品管理
        $meta_title=isset($meta_title[ACTION_NAME])?$meta_title[ACTION_NAME]:'商品管理';
        //绑定数据
        $this->assign('meta_title',$meta_title);
        //初始化自动实例化Goods模型
        $this->_model=D('Goods');
    }
    public function index(){
        $keyword = I('get.keyword', '');
        $cond = array(
            'name' => array('like', '%' . $keyword . '%'),
        );
        $page = I('get.p', 1);
        $this->assign($this->_model->getPageResult($cond, $page));
        $this->assign('keyword', $keyword);

        $this->display();
    }
    public function add(){
        if(IS_POST){
            if ($this->_model->create() === false) {
                $this->error($this->_model->getError());
            }
            if ($this->_model->addGoods() === false) {
                $this->error($this->_model->getError());
            }
            $this->success('添加成功', U('index'));
        }else{
            $this->_before_view();
            $this->display();
        }
    }
    public function edit($id){
        if(IS_POST){
            if ($this->_model->create() === false) {
                $this->error($this->_model->getError());
            }
            if ($this->_model->updateGoods() === false) {
                $this->error($this->_model->getError());
            }
            $this->success('修改成功', U('index'));
        }else{
            $this->_before_view();
            $this->assign('row',$this->_model->getGoodsInfo($id));
            $this->display('add');
        }
    }

    /**
     * 获取视图所需页面数据
     */
    protected function _before_view(){
        //读取品牌列表,在商品模型新建获取id,name字段,多虑状态为-1的数据
        $this->assign('brand_list',D('Brand')->getList());
        //读取供应商列表,在商品模型新建获取id,name字段,多虑状态为-1的数据
        $this->assign('supplier_list',D('Supplier')->getList());
        //获取产品分类列表,返回到模板的js代码,需要json字符串,用json_encode转换
        $this->assign('goods_category_list',json_encode(D('GoodsCategory')->getList()));
    }
}