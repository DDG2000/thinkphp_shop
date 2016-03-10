<?php
/**
 * Created by PhpStorm.
 * User: 孙歆雁1
 * Date: 2016/3/10
 * Time: 23:53
 */

namespace Admin\Controller;


class GoodsCategoryController extends \Think\Controller
{
    public function index(){

    }
    public function add(){
        if(IS_POST){

        }else{
            $model=D('GoodsCategory');
            $rows=$model->getList();
//            dump($rows);

            foreach($rows as $key=>$value){
                $rows[$key]['pId']=$value['parent_id'];
            }
//            dump($rows);
            $rows=json_encode($rows);
//            dump($rows);
            $this->assign('rows',$rows);
            $this->display('add');
        }
    }
}