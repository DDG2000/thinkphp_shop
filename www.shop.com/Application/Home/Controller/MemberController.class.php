<?php
/**
 * Created by PhpStorm.
 * User: 孙歆雁1
 * Date: 2016/3/18
 * Time: 13:34
 */

namespace Home\Controller;


class MemberController extends \Think\Controller
{
    private $_model = null;

    protected function _initialize()
    {
        //标题数组
        $meta_title = array(
            'index' => '会员管理',
            'add' => '添加会员',
            'edit' => '编辑会员',
        );
        //方法不在数组中，默认为会员管理
        $meta_title = isset($meta_title[ACTION_NAME]) ? $meta_title[ACTION_NAME] : '会员管理';
        $this->assign('meta_title', $meta_title);
        $this->_model = D('Member');
    }
    public function register(){
        if(IS_POST){
            //对数据进行自动
            if($this->_model->create()===false){
                $this->error($this->_model->getError());
            }
//            var_dump($this->data['salt']);
//            exit;
            if ($this->_model->addMember() === false) {
                $this->error($this->_model->getError());
            }
            $this->success('注册成功',U('Index/index'));
        }else{
            $this->display();
        }
    }

    public function checkByParam(){
        $param=I('get.');
        $flag=true;
        if($this->_model->where($param)->count()){
            $flag=false;
        }
        echo json_encode($flag);
        exit;
    }

    /**发型验证码用于手机注册
     * @param $telephone
     */
    public function sendSMS($telephone){
        $code=\Org\Util\String::randNumber(1000,9999);
        $param=array(
            'code'=>$code,
            'product'=>'顺丰快递',
        );
        //如果发送成功,将验证码存到session中
        if(sendSMS($telephone,$param)){
            $data=array(
                'code'=>$code,
                'telephone'=>$telephone,
            );
            login($data);
            tel_code($data);
            $return=array(
                'status'=>1,
            );
        }else{
            $return=array(
                'status'=>0,
            );
        }
        $this->ajaxReturn($return);
        $this->ajaxReturn(tel_code());
        exit;
    }
}