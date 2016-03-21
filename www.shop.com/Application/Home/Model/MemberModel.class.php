<?php

namespace Home\Model;
class MemberModel extends \Think\Model
{
    protected $_validate=array(
        array('username','require','用户名必填'),
        array('username','','用户名已存在',self::EXISTS_VALIDATE,'unique'),
        array('password','require',',密码必填'),
        array('password','6,20','密码必须是6-20个字符',self::EXISTS_VALIDATE,'length'),
        array('repassword','password','两次密码不一致',self::EXISTS_VALIDATE,'confirm'),
        array('email','email','邮箱不合法'),
        array('email','','邮箱已存在',self::EXISTS_VALIDATE,'unique'),
        array('tel','require','手机号必填'),
        array('tel','','手机号已存在',self::EXISTS_VALIDATE,'unique'),
        array('captcha','checkTelCode','手机验证码不正确',self::EXISTS_VALIDATE,'callback'),
        array('checkcode','checkCode','验证码不正确',self::EXISTS_VALIDATE,'callback'),
    );

    protected $_auto=array(
        array('salt','\Org\Util\String::randString',self::MODEL_INSERT,'function',array(4)),
        array('add_time',NOW_TIME,self::MODEL_INSERT),

    );

    /**验证手机验证码是否正确
     * TODO:session获取的手机验证码为空
     * @param $tel_code
     * @return bool
     */
    protected function checkTelCode($tel_code){
        $telephone = I('post.tel');
        $session_data = tel_code();
        tel_code(array());//销毁数据,避免下次还可以使用这个验证码
        if($session_data['telephone']==$telephone &&
            $session_data['code'] == $tel_code){
            return true;
        }else{
            return false;
        }
    }

    /**验证验证码是否正确
     * @param $code
     * @return bool
     */
    protected function checkCode($code){
        $verify=new \Think\Verify();
        return $verify->check($code);
    }

    /**添加一条用户数据
     * @return mixed
     */
    public function addMember(){
        $this->data['password']=my_mcrypt(
            $this->data['password'],$this->data['salt']);
        return $this->add();
    }

    public function login(){
        //验证验证码
        $captcha=I('post.checkcode');
        $verify=new \Think\Verify;
        if($verify->check($captcha)===false){
            $this->error='验证码错误';
            return false;
        }
        //验证有户名和密码是否为空

        $username=I('post.username');
        $password=I('post.password');
        if(empty($username)||empty($password)){
            $this->error='用户或密码为空';
            return false;
        }
        //验证是否有此用户
        $userinfo=$this->where(array('username'=>$username))->find();
        if(empty($userinfo)){
            $this->error='用户不存在';
            return false;
        }
        //验证密码是否匹配
        $salt=$userinfo['salt'];
        $password=my_mcrypt($password,$salt);
        if($userinfo['password']!=$password){
            $this->error='密码错误';
            return false;
        }
        //记录用户最后登录的时间和ip
        $data=array(
            'id'=>$userinfo['id'],
            'last_login_time'=>NOW_TIME,
            'last_login_ip'=>get_client_ip(1),
        );
        //保存用户信息>>1更新用户信息
        $this->save($data);
        return $userinfo;
    }
}