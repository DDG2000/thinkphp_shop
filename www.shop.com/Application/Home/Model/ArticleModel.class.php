<?php
/**
 * Created by PhpStorm.
 * User: 孙歆雁1
 * Date: 2016/3/20
 * Time: 2:05
 */

namespace Home\Model;


class ArticleModel extends \Think\Model
{
    public function getHelpArticleList(){
        $cond=array(
            'status'=>array('gt',0),
            'id'=>array('elt',5),
        );
        $article_categories=M('ArticleCategory')->where($cond)->order('sort')->select();
        $return=array();
        foreach($article_categories as $article_category){
            $return[$article_category['catename']]=$this->getArticleList($article_category['id']);
        }
        return $return;
    }

    public function getArticleList($article_category_id){
        $cond=array(
            'status'=>array('gt',0),
            'article_category_id'=>$article_category_id,
        );
        return $this->field('id,name,article_category_id')->where($cond)->order('sort')->limit(6)->select();
    }
}