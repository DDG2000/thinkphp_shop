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
    var_dump($resp);
    exit;
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
        var_dump(session('tel_code'));
        //如果取得的值为空,赋空值
        if(!$data){
            $data=array();
        }
        return $data;
    }else{
        var_dump($data);
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
