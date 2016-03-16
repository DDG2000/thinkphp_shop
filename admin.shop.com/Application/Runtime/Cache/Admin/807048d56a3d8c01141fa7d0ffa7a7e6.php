<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - <?php echo ($meta_title); ?> </title>
<meta name="robots" content="noindex, nofollow"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://admin.shop.com/Public/CSS/general.css" rel="stylesheet" type="text/css" />
<link href="http://admin.shop.com/Public/CSS/main.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="http://admin.shop.com/Public/CSS/page.css" />
<link rel="stylesheet" type="text/css" href="http://admin.shop.com/Public/EXT/treegrid/css/jquery.treegrid.css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('add');?>">添加菜单</a></span>
    <span class="action-span1"><a href="<?php echo U('Index/main');?>">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($meta_title); ?> </span>
</h1>
<div style="clear:both"></div>
<form method="post" action="" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1" class="tree">
            <tr>
                <th>菜单名称</th>
                <th>分类简介</th>
                <th>操作</th>
            </tr>
            <?php if(is_array($rows)): foreach($rows as $key=>$row): ?><tr class="treegrid-<?php echo ($row["id"]); ?> <?php if(($row["level"]) != "1"): ?>treegrid-parent-<?php echo ($row["parent_id"]); endif; ?>">
                <td><?php echo ($row["name"]); ?></td>
                <td align="center"><?php echo ($row["intro"]); ?></td>
                <td align="center">
                    <a href="<?php echo U('edit',array('id'=>$row['id']));?>" title="编辑">编辑</a> |
                    <a href="<?php echo U('delete',array('id'=>$row['id']));?>" title="移除">移除</a> 
                </td>
            </tr><?php endforeach; endif; ?>
            <tr>
                <td align="right" nowrap="true" colspan="6">
                    <div class='page'>
                        <?php echo ($page_html); ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</form>

<div id="footer">
共执行 3 个查询，用时 0.021251 秒，Gzip 已禁用，内存占用 2.194 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
<script type="text/javascript" src="http://admin.shop.com/Public/JS/jquery-1.11.2.js"></script>
<script type="text/javascript" src="http://admin.shop.com/Public/EXT/treegrid/js/jquery.treegrid.js"></script>

<script type="text/javascript">
    function change_status(id,status){
        url='<?php echo U("changeStatus");?>?id=' + id + '&status=' + status;
        location.href=url;
    }
    
    $(function(){
        $('.tree').treegrid();//将列表展示成treegrid的样式
    });
</script>
</body>
</html>