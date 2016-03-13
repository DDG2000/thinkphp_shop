<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - <?php echo ($meta_title); ?> </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://admin.shop.com/Public/CSS/general.css" rel="stylesheet" type="text/css" />
<link href="http://admin.shop.com/Public/CSS/main.css" rel="stylesheet" type="text/css" />
<link href="http://admin.shop.com/Public/CSS/page.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('add');?>">添加新商品</a></span>
    <span class="action-span1"><a href="<?php echo U('Index/main');?>">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($meta_title); ?> </span>
</h1>
    <div style="clear:both"></div>
<div class="form-div">
    <form action="" name="searchForm">
        <img src="http://admin.shop.com/Public/IMG/icon_search.gif" width="26" height="22" border="0" alt="search" />
        <!-- 分类 -->
        <select name="cat_id">
            <option value="0">所有分类</option>
            <?php if(is_array($cat_list)): foreach($cat_list as $key=>$val): ?><option value="<?php echo ($row["cat_id"]); ?>"><?php echo (str_repeat('&nbsp;&nbsp;',$row["lev"])); echo ($row["cat_name"]); ?></option><?php endforeach; endif; ?>
        </select>
        <!-- 品牌 -->
        <select name="brand_id">
            <option value="0">所有品牌</option>
            <?php if(is_array($brand_list)): foreach($brand_list as $key=>$val): ?><option value="<?php echo ($row["brand_id"]); ?>"><?php echo ($row["brand_name"]); ?></option><?php endforeach; endif; ?>
        </select>
        <!-- 推荐 -->
        <select name="intro_type">
            <option value="0">全部</option>
            <option value="is_best">精品</option>
            <option value="is_new">新品</option>
            <option value="is_hot">热销</option>
        </select>
        <!-- 上架 -->
        <select name="is_on_sale">
            <option value=''>全部</option>
            <option value="1">上架</option>
            <option value="0">下架</option>
        </select>
        <!-- 关键字 -->
        关键字 <input type="text" name="keyword" size="15" />
        <input type="submit" value=" 搜索 " class="button" />
    </form>
</div>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>编号</th>
                <th>商品名称</th>
                <th>货号</th>
                <th>价格</th>
                <th>上架</th>
                <th>精品</th>
                <th>新品</th>
                <th>热销</th>
                <th>推荐排序</th>
                <th>库存</th>
                <th>操作</th>
            </tr>
            <?php if(is_array($rows)): foreach($rows as $key=>$row): ?><tr>
                <td align="center"><?php echo ($row["id"]); ?></td>
                <td align="center" class="first-cell"><span><?php echo ($row["name"]); ?></span></td>
                <td align="center"><span onclick=""><?php echo ($row["sn"]); ?></span></td>
                <td align="center"><span><?php echo ($row["shop_price"]); ?></span></td>
                <td align="center"><img src="http://admin.shop.com/Public/IMG/<?php echo ($row["is_on_sale"]); ?>.gif"/></td>
                <td align="center"><img src="http://admin.shop.com/Public/IMG/<?php echo ($row["is_best"]); ?>.gif"/></td>
                <td align="center"><img src="http://admin.shop.com/Public/IMG/<?php echo ($row["is_new"]); ?>.gif"/></td>
                <td align="center"><img src="http://admin.shop.com/Public/IMG/<?php echo ($row["is_hot"]); ?>.gif"/></td>
                <td align="center"><span>100</span></td>
                <td align="center"><span><?php echo ($row["stock"]); ?></span></td>
                <td align="center">
               <a href="<?php echo U('edit',array('id'=>$row['id']));?>" title="编辑"><img src="http://admin.shop.com/Public/IMG/icon_edit.gif" width="16" height="16" border="0" /></a>
                <a href="<?php echo U('delete',array('id'=>$row['id']));?>" onclick="" title="回收站"><img src="http://admin.shop.com/Public/IMG/icon_trash.gif" width="16" height="16" border="0" /></a></td>
            </tr><?php endforeach; endif; ?>
        </table>

    <div class="page">
        <?php echo ($page_html); ?>
    </div>
    </div>
</form>

<div id="footer">
共执行 7 个查询，用时 0.028849 秒，Gzip 已禁用，内存占用 3.219 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>