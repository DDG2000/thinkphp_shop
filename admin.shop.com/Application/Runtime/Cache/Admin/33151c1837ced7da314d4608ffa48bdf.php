<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="shortcut icon" href="http://admin.shop.com/Public/IMG/top_loader.gif" type="image/x-icon">
<title>ECSHOP 管理中心 - <?php echo ($meta_title); ?> </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://admin.shop.com/Public/CSS/general.css" rel="stylesheet" type="text/css" />
<link href="http://admin.shop.com/Public/CSS/main.css" rel="stylesheet" type="text/css" />
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" type="text/css" href="http://admin.shop.com/Public/CSS/page.css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('add');?>">添加文章</a></span>
    <span class="action-span1"><a href="<?php echo U('Index/main');?>">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($meta_title); ?> </span>
    <div style="clear:both"></div>
</h1>
<div class="form-div">
    <form action="<?php echo U('');?>" name="searchForm">
    <img src="http://admin.shop.com/Public/IMG/icon_search.gif" width="26" height="22" border="0" alt="search" />
    <input type="text" name="keyword" size="15" value="<?php echo ($keyword); ?>"/>
    <input type="submit" value=" 搜索 " class="button" />
    </form>
</div>
<form method="post" action="" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>ID</th>
                <th>文章名称</th>
                <th>文章分类</th>
                <th style="width: 400px">文章简介</th>
                <th>排序</th>
                <th>是否显示</th>
                <th>录入时间</th>
                <th>操作</th>
            </tr>
            <?php if(is_array($rows)): foreach($rows as $key=>$row): ?><tr>
                <td class="first-cell"><?php echo ($row["id"]); ?></td>
                <td class="first-cell"><?php echo ($row["name"]); ?></td>
                <td class="first-cell"><?php echo ($article_categories[$row[article_category_id]]); ?></td>
                <td align="center"><?php echo ($row["intro"]); ?></td>
                <td align="center"><?php echo ($row["sort"]); ?></td>
                <td align="center"><img src="http://admin.shop.com/Public/IMG/<?php echo ($row["status"]); ?>.gif" onclick="change_status(<?php echo ($row["id"]); ?>,1-<?php echo ($row["status"]); ?>)"/></td>
                <td align="center"><?php echo (date('Y-m-d',$row["inputtime"])); ?></td>
                <td align="center">
                    <a href="<?php echo U('edit',array('id'=>$row['id']));?>" >编辑</a> |
                    <a href="<?php echo U('delete',array('id'=>$row['id']));?>" >移除</a>
                </td>
            </tr><?php endforeach; endif; ?>
            <tr>
                <td align="right" nowrap="true" colspan="6">
                    <div class="page">
                        <?php echo ($page_html); ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</form>
<script type="text/javascript" >
    function change_status(id,status){
        url='<?php echo U("delete");?>?id=' + id + '&status=' + status;
        console.debug(url);
        location.href=url;
    }
</script>
<div id="footer">
共执行 3 个查询，用时 0.021251 秒，Gzip 已禁用，内存占用 2.194 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>