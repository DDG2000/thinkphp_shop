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
        array('salt','\Org\Util\String::randNumber(1000,9999);',self::MODEL_INSERT,'function',array(4)),
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
        var_dump(tel_code());
        tel_code(array());//销毁数据,避免下次还可以使用这个验证码
        exit;
        if($session_data['telephone']==$telephone && $session_data['code'] == $tel_code){
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
        $this->data['password']=my_mcrypt($this->data['password'],$this->data['salt']);
       return $this->add();
    }
}