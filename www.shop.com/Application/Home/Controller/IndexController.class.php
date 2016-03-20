<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    //初始化自动完成，分派数据显示标题,实例化模型
    //自动实例化模型
//    private $_model=null;
    protected function _initialize(){
        //标题数组
        $meta_title=array(
            'index'=>'京西商城',
            'goods'=>'商品详情',
        );
        //方法不在数组中，默认为商品管理
        $meta_title=isset($meta_title[ACTION_NAME])?$meta_title[ACTION_NAME]:'京西商城';
        //绑定数据
        $this->assign('meta_title',$meta_title);
        //初始化自动实例化Goods模型
//        $this->_model=D('Index');
        $model=D('GoodsCategory');
        $this->assign('goods_categories',$model->getAllCategory());
        //获取页脚的文章
        $article_list=D('Article')->getHelpArticleList();
//        dump($article_list);
        $this->assign('article_list',$article_list);
    }
    //首页
    public function index(){
     $this->display();
    }

    public function goods(){
        $this->display();
    }
}