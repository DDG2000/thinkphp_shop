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
        //初始化自动实例化Goods模型,数据缓存
//        $start=microtime();
        if(!$goods_categories=S('goods_categories')){
            $goods_categories=D('GoodsCategory')->getAllCategory();
            S('goods_categories',$goods_categories);
        }
        $this->assign('goods_categories',S('goods_categories'));
        //获取页脚的文章,数据缓存
        if(!$article_list=S('article_list')){
            $article_list=D('Article')->getHelpArticleList();
            S('article_list',$article_list);
        }
        $this->assign('article_list',S('article_list'));
//        $stop=microtime();
//        echo  $stop-$start;
//        exit;
    }
    //首页
    public function index(){
        $model=D('Goods');
        $model->getGoodsByStatus(1);
        $data=array(
          'new_list'=>  $model->getGoodsByStatus(1),
          'hot_list'=>  $model->getGoodsByStatus(2),
          'best_list'=>  $model->getGoodsByStatus(4),
        );
        $this->assign($data);
        $this->display();
    }

    /**
     * 商品展示页面
     */
    public function goods($id){
        $model = D('Goods');
        $row = $model->getGoodsInfo($id);
        $this->assign('row',$row);
        $this->display();
    }
}