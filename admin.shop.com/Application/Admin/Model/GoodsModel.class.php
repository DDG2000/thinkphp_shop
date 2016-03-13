<?php
/**
 * Created by PhpStorm.
 * User: 孙歆雁1
 * Date: 2016/3/13
 * Time: 14:47
 */

namespace Admin\Model;


class GoodsModel extends \Think\Model
{
    protected $_validate=array(
        array('sn','','货号已存在',self::EXISTS_VALIDATE,'unique',self::MODEL_INSERT),
    );
    protected $_auto=array(
        array('inputtime',NOW_TIME),   //自动完成添加时间
        array('goodstatus','array_sum',self::MODEL_BOTH,'function'), //将数组相加
//        array('sn','setSn',self::MODEL_INSERT,'callback'),      //自动生成sn回调方法
    );

    //生成sn方法
    protected function setSn($sn){
        if(empty($sn)){            //如果sn为空
            $model=M('GoodsNumber');
            $date=date('Ymd');     //找到今天的日期
            $count=$model->getFieldByDate($date,'count'); //根据日期找到计数
            if($count){   //计数存在
                $count++;   //计数加1
                $cond=array('date'=>$date); //将表中的当天的计数加1
                $model->where($cond)->setInc('count',1);
            }else{       //计数不存在
                $count=1;  //设为一
                $data=array(
                    'date'=>$date,
                    'count'=>$count,
                );
                $model->add($data);  //新加当天的计数
            }
            $sn='SN'.$date.str_pad($count,8,0,STR_PAD_LEFT); //拼接成货号
        }
        return $sn;
    }

    public function addGoods(){
        $this->startTrans();
        //开启事物,sn赋值就要在事物当中,不用自动完成,自己调用自己,sn有值就是取值,没值就是赋值
        $this->data['sn']=$this->setSn($this->data['sn']);
//        dump($this->data);
//        exit;
        /**
         * 1商品的基本信息
         * 2商品的详细信息
         */
        if (($id               = $this->add()) === false) {
            $this->error = '添加商品失败';
            $this->rollback();
            return false;
        }

        //保存商品详细信息
        if ($this->_addContent($id) === false) {
            $this->error = '添加商品详情失败';
            $this->rollback();
            return false;
        }
        $this->commit();

    }

    /**
     * 控制插入商品详情返回bool
     * @param $goods_id
     * @return bool
     */
    private function _addContent($goods_id){
        $model=M('GoodsIntro');
        $content=I('post.content','',false);
        $data=array(
            'goods_id'=>$goods_id,
            'content'=>$content
        );
        return $model->add($data)!==false;
    }

    //获取列表
    //分页
    //搜索
    //排序
    //过滤已删除
    public function getPageResult(array $cond=array(),$page=1){
        $count=$this->where($cond)->where('status<>-1')->count();
        $rows=$this->where($cond)->where('status<>-1')->order('sort asc')->page($page,C('PAGE_SIZE'))->select();
        $page=new \Think\Page($count,C('PAGE_SIZE'));
        $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $page_html=$page->show();
        //增加元素
        foreach($rows as $key=>$value){
            $value['is_best']=($value['goods_status'] & 1)?1:0;
            $value['is_new']=($value['goods_status'] & 2)?1:0;
            $value['is_hot']=($value['goods_status'] & 4)?1:0;
            $rows[$key]=$value;
        }
        return array('page_html'=>$page_html,'rows'=>$rows);
    }

    /**
     * 取出一个商品的详细信息
     * @param $goods_id
     */
    public function getGoodsInfo($goods_id){
        $row=$this->find($goods_id);
        $row['is_best']=($row['goods_status'] & 1)?1:0;
        $row['is_new']=($row['goods_status'] & 2)?1:0;
        $row['is_hot']=($row['goods_status'] & 4)?1:0;
        $row['content']=M('GoodsIntro')->getFieldByGoodsId($goods_id,'content');
//        dump($row);
        return $row;
    }

    /**
     * 保存商品
     */
    public function updateGoods() {
        $request_data = $this->data;
        $this->startTrans();
        //1.保存基本信息
        if ($this->save() === false) {
            $this->error = '保存失败';
            $this->rollback();
            return false;
        }
        //2.保存详细描述
        if ($this->updateContent($request_data['id']) === false) {
            $this->error = '保存详细描述失败';
            $this->rollback();
            return false;
        }

        //执行相册的保存
        if ($this->_addGallery($request_data['id']) === false) {
            $this->error = '保存相册图片失败';
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }

    /**
     * 修改商品的详细描述
     * @param integer $goods_id
     * @return boolean
     */
    private function updateContent($goods_id) {
        $data = array(
            'goods_id' => $goods_id,
            'content'  => I('post.content', '', false),
        );
        return M('GoodsIntro')->save($data) !== false;
    }

    /**
     * 插入相册
     * @param integer $goods_id 商品的id
     * @return boolean
     */
    private function _addGallery($goods_id) {
        //收集相册图片
        $paths = I('post.path');
        $data  = array();
        foreach ($paths as $path) {
            $data[] = array(
                'goods_id' => $goods_id,
                'path'     => $path,
            );
        }
        if ($data) {
            //保存相册图片
            $model = M('GoodsGallery');
            return $model->addAll($data);
        }
        return true;
    }
}