<?php
/**
 * Created by PhpStorm.
 * User: 孙歆雁1
 * Date: 2016/3/7
 * Time: 17:47
 */

namespace Admin\Model;


class ArticleModel extends \Think\Model
{
    //自动验证
    protected $_validate=array(
        array('name','require','文章名字不能为空'),
        array('name','','文章名字已存在',self::EXISTS_VALIDATE,'unique'),
    );
    protected $_auto=array(
        array('inputtime','time',self::MODEL_INSERT,'function'),
    );

    //获取列表
    //分页
    //搜索
    //排序
    //过滤已删除
    public function getPageResult(array $cond=array(),$page=1){
        $count=$this->where($cond)->where('status<>-1')->count();
        $rows=$this->where($cond)->where('status<>-1')->order('sort asc')->page($page,C('PAGE_SIZE'))->select();
//        dump($rows);
        $page=new \Think\Page($count,C('PAGE_SIZE'));
        $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $page_html=$page->show();
        return array('page_html'=>$page_html,'rows'=>$rows);
    }

    //修改或删除文章，删除的话名字加上_del
    /**
     * @param $id 修改的id
     * @param int $status 修改后的状态
     * @return bool|int 返回失败或影响的行数
     */
    public function changeStatus($id,$status=-1){
        $data=array(
            'status'=>$status,
            'name'=>array('exp','concat(name,"_del")'),
            'id'=>$id,
        );
        if($status!=-1){
            unset($data['name']);
        }
       return $this->save($data);
    }

    //添加文章
    public function addArticle(){
        //添加基本数据
        $this->data['intro']=mb_substr(I('post.content'),15);
        if(($id=$this->add())===false){
            $this->error = '添加失败';
            return false;
        }
        //新建模型
        $model=M('ArticleContent');
        //收集数据
        $data=array(
            'article_id'=>$id,
            'content'=>I('post.content'),
        );
        //添加数据
        if($model->add($data)===false){
            $this->error = '添加详细文章失败';
            return false;
        }
    }

    public function updateArticle(){
        //添加基本数据
        $this->data['intro']=mb_substr(I('post.content'),15);
        if($this->save()===false){
//            dump($this->getLastSql());
//            exit;
            $this->error = '更新失败';
            return false;
        }
        $id=I('post.id');
        //新建模型
        $model=M('ArticleContent');
        //收集数据
        $data=array(
            'content'=>I('post.content'),
        );
        //添加数据
        if($model->where(array('id'=>$id))->save($data)===false){
            $this->error = '添加详细文章失败';
            return false;
        }
    }
}