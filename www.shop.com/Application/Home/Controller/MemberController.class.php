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
            //对数据进行收集
            if($this->_model->create()===false){
                $this->error($this->_model->getError());
            }
            if ($this->_model->addMember() === false) {
                $this->error($this->_model->getError());
            }
            if ($this->sendMail()===false) {
                $this->error('邮件发送失败,请到重发邮件页面重新发送', U('Index/index'));
            }
            $this->success('注册成功',U('Member/login'));
        }else{
            $this->display();
        }
    }

    /**
     * 检验是否已存在
     */
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
            'product'=>'顺丰快递',);
        //如果发送成功,将验证码存到session中
        if(sendSMS($telephone,$param)){
            $data=array(
                'code'=>$code,
                'telephone'=>$telephone,);
            tel_code($data);
            $return=array(
                tel_code(),
                'status'=>1,);
        }else{
            $return=array(
                'status'=>0,);}
        $this->ajaxReturn($return);
        exit;
    }

    /**
     * 发送邮件,尝试三次,如果三次都失败,就不再尝试
     * @return boolean
     */
    private function sendMail() {
        for ($i = 0; $i < 3;  ++$i) {
            //发送邮件
            $address = I('post.email');
            $subject = '欢迎注册ayiyayo商城';
            $param   = array(
                'email'    => $address,
                'token' => md5(\Org\Util\String::randString(17)),
            );
            $url     = U('active', $param, true, true);
            $content = <<<EMIAL
欢迎注册,请点击以下链接激活账号：
<a href="$url" target="_blank">$url</a>
(如不能打开页面，请复制该地址到浏览器打开)'
EMIAL;
            if (sendMail($address, $content, $subject)){
                //记录数据到数据表
                M('EmailToken')->delete($address);
                M('EmailToken')->add($param);
                return true;
            }
        }
        return false;
    }

    public function login(){
        if(IS_POST){
            if (($userinfo=$this->_model->login()) === false) {
                $this->error($this->_model->getError());
            }
            //将用户的信息保存到seesion中,抽到函数里>>2保存用户信息到session
            login($userinfo);
            //判断是否要自动登陆/取出菜单列表/获取用户权限并保存
            if(I('post.chb')){
                $data = array(
                    'member_id'=>$userinfo['id'],
                    'token'=>  createToken(),);
                M('MemberToken')->add($data);//存到数据表中>>3保存用户id和token到admin_token表中
                token($data);//保存到cookie>>4保存到cookie中
            }else{
                cookie('token',null);//删除token
                $cond = array(
                    'member_id'=>$userinfo['id'],);
                M('MemberToken')->where($cond)->delete();
            }
            $this->success('登录成功', U('Index/index'));
        }else{
            $this->display();
        }
    }

    public function active($email,$token){
        $model = M('EmailToken');
        //判断数据表中是否有对应记录
        $cond = array(
            'email'=>$email,
            'token'=>$token,
        );
        if(!$model->where($cond)->count()){
            $this->error('验证信息不匹配,或者已经激活成功',U('Index/index'));
        }
        //如果有就激活账户
        if($this->_model->activeMember($email) === false){
            $this->error('激活失败,请稍后再试',U('Index/index'));
        }
        //删除这条记录
        if($model->delete($email) === false){
            $this->error('激活失败,请稍后再试',U('Index/index'));
        }
        $this->success('激活成功',U('Index/index'));
    }
}