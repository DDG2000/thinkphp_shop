<?php
function arr2select(array $data,$value_field,$name_fieid,$name='',$class=''){
    $html='';
    $html.='<select name="'.$name.'" class="'.$name.'">';
    $html.='<option value="0">请选择...</option>>';
    foreach($data as $item){
        $html.='<option value="{$item['']">请选择...</option>>'
    }
}