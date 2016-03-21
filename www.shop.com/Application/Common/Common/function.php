<?php
function sendSMS($telephone,$param){
    vendor('Alidayu.Autoloader');
    $c = new \TopClient;
    $c->format='json';
    $c->appkey = '23328842';
    $c->secretKey = 'dcafdaa14e5c2584f6b8f9bd0307a0b1';
    $req = new \AlibabaAliqinFcSmsNumSendRequest;
    $req->setSmsType("normal");
    $req->setSmsFreeSignName("顺丰快递");
    $param=json_encode($param);
    $req->setSmsParam($param);
    $req->setRecNum($telephone);
    $req->setSmsTemplateCode("SMS_6365005");
    $resp = $c->execute($req);
    if(isset($resp->result->success) && $resp->result->success=='true'){
        return true;
    }else{
       return false;
    }
}

/**保存或获取电话验证码信息
 * @param null $data
 * @return array|mixed|null
 */
function tel_code($data=null){
    //如果$data为空,取的验证码电话信息
    if(is_null($data)){
        $data=session('tel_code');
//        var_dump(session('tel_code'));
        //如果取得的值为空,赋空值
        if(!$data){
            $data=array();
        }
        return $data;
    }else{
//        var_dump($data);
        //如果有值传入,赋值
        session('tel_code',$data);
    }
}

/**
 * 自定义加盐加密算法
 * @param string $string 原密码
 * @param string $salt 盐
 * @return string 加盐加密后的结果
 */
function my_mcrypt($string,$salt){
    return md5(md5($string).$salt);
}

function getRedis(){
    $redis=new \Redis;
    $redis->connect('127.0.0.1',6379);
    return $redis;
}

/**
 * 保存和获取用户的session信息
 */
function login($data=null){
    if($data){
        session('userinfo',$data);
    }else{
        $userinfo=session('userinfo');
        if(!$userinfo){
            $userinfo=array();
        }
        return $userinfo;
    }
}

/**
 * 生成令牌.
 * @param type $len
 * @return type
 */
function createToken($len = 32){
    $token = mcrypt_create_iv($len);
    $token = base64_encode($token);
    $token = substr($token,0,$len);
    return $token;
}

/**
 * 获取或者保存token信息
 * @param array|null $data
 * @return array|null
 */
function token($data=null){
    if(is_null($data)){
        $token = cookie('token');
        if(!$token){
            $token=array();
        }else{
            $token=unserialize($token);
        }
        return $token;

    }else{
        $data = serialize($data);
        cookie('token',$data,604800);//存7天

    }
}

function sendMail($address, $content, $subject) {
    vendor('phpmailer.PHPMailerAutoload');
    $mail = new \PHPMailer;
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $email_setting = C('EMAIL_SETTING');
    $mail->Host     = $email_setting['Host'];  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $email_setting['Username'];                 // SMTP username
    $mail->Password = $email_setting['Password'];                           // SMTP password

    $mail->setFrom($email_setting['Username']);
    $mail->addAddress($address);     // Add a recipient

    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body    = $content;
    $mail->CharSet = 'UTF-8';

    return $mail->send();
}

