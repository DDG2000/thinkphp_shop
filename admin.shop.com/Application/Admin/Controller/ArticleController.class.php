<?php
/**
 * Created by PhpStorm.
 * User: 孙歆雁1
 * Date: 2016/3/7
 * Time: 17:46
 */

namespace Admin\Controller;


class ArticleController extends \Think\Controller
{
    //初始化自动完成，分派数据显示标题
    //自动实例化模型
    private $_model=null;
    protected function _initialize(){
    //标题数组
    $meta_title=array(
        'index'=>'文章管理',
        'add'=>'添加文章',
        'edit'=>'编辑文章',
        'delete'=>'删除文章',
    );
    //方法不在数组中，默认为文章管理
    $meta_title=isset($meta_title[ACTION_NAME])?$meta_title[ACTION_NAME]:'文章管理';
    $this->assign('meta_title',$meta_title);
    $this->_model=D('Article');
    }

    public function index(){
        $keyword=I('get.keyword','');
        $cond=array(
            'name'=>array('like','%'.$keyword.'%'),
        );
        $page=I('get.p',1);
        $this->assign($this->_model->getPageResult($cond,$page));
        $this->assign('keyword',$keyword);
        $this->display();
    }
    public function add(){
        if(IS_POST){
            //收集数据验证数据是否合法

            if($this->_model->create()===false){
                $this->error($this->_model->getError());
            }
            if($this->_model->addArticle()===false){
                $this->error($this->_model->getError());
            }
            $this->success('添加成功',U('index'));
        }else{
            $this->assign('cates',M('ArticleCategory')->select());
            $this->display();
        }
    }

    //文章的修改
    public function edit($id){
        if(IS_POST){
            if($this->_model->create()===false){
                $this->error($this->_model->getError());
            }
            //执行保存操作失败
            if($this->_model->updateArticle($id)===false){
                $this->error($this->_model->getError());
            }
            $this->success('修改成功',U('index'));
        }else{
            //展示数据表中的数据,绑定文章列表数据
            $row=$this->_model->find($id);
            $articleinfo=$this->_model->find($id);
            $articlecateid=$articleinfo['article_category_id'];
            $this->assign('row',$row);
//            dump($row);
            //绑定文章内容表数据
            $info=M('ArticleContent')->where(array('id'=>$id))->find();
            $this->assign('info',$info);
            //绑定文章回显分类
            $data=M('ArticleCategory')->where(array('id'=>$articlecateid))->find();
            $this->assign('data',$data);
//            dump($data);
            //绑定文章所有分类
            $this->assign('cates',M('ArticleCategory')->select());
//            dump(M('ArticleCategory')->select());
            $this->display('add');
        }
    }
    //执行文章的删除操作，将状态改为-1
    //或则执行修改操作，将状态在0/1之间转换
    public function delete($id,$status=-1){
        if($this->_model->changeStatus($id,$status)===false){
            $this->error($this->_model->getError());
        }else{
            if($status==-1){
                echo 11;
                $this->success('删除成功',U('index'));
            }else{
                $this->success('修改成功',U('index'));
            }
        }
    }
}