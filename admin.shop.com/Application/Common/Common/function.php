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
    $html.='<option value="0">请选择...</option>>';
    foreach($data as $item){
        $html.="<option value='$item[$value_field]'>{$item[$name_fieid]}</option>>";
    }
    $html.="</select>";
    return $html;
}