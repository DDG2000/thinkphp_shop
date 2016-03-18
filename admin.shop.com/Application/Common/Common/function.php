<?php
/**
 * 将关联数组转化成一个下拉列表
 * @param array $data   数据库中的关联数组
 * @param $value_field   value值字段
 * @param $name_fieid   名字段
 * @param string $name  表单提交的控件name属性
 * @return string       具体下拉列表的html代码
 */
function arr2select(array $data,$value_field,$name_fieid,$name=''){
    $html='';
    $html.="<select name='$name' class='$name'>";
    $html.='<option value="0">请选择...</option>';
    foreach($data as $item){
        $html.="<option value='$item[$value_field]'>{$item[$name_fieid]}</option>>";
    }
    $html.="</select>";
    return $html;
}

/**将索引数组转换为关联数组
 * @param array $data
 * @param string $index_name
 */
function index2assoc(array $data,$index_name='id'){
    $return=array();
    foreach($data as $item){
        $return[$item['id']]=$item;
    }
    return $return;
}

/**
 * @param array $data
 * @param string $name
 * @param string $selected_value
 * @return string
 */
function onearr2select(array $data, $name = '', $selected_value = '') {


    $html = "<select name='$name' class='$name'>";
    $html .= '<option value="">请选择...</option>';
    foreach ($data as $key => $value) {
        $key = (string)$key;
        if ($selected_value === $key) {
            $html .= "<option value='$key' selected='selected'>$value</option>";
        } else {
            $html .= "<option value='$key'>$value</option>";
        }
    }
    $html .= "</select>";
    return $html;
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

/**保存和获取用户可以操作的路径session
 * @param null $data
 * @return mixed
 */
function paths($data=null){
    if($data){
        session('paths',$data);
    }else{
        $paths= session('paths');
        if(!$paths){
            $paths=array();
        }
        return $paths;
    }
}

/**
 * 保存和获取用户可以操作的权限id
 *
 * @param null $data
 * @return mixed
 */
function pids($data=null){
    if($data){
        session('pids',$data);
    }else{
        $pids= session('pids');
        if(!$pids){
            $pids=array();
        }
        return $pids;
    }
}