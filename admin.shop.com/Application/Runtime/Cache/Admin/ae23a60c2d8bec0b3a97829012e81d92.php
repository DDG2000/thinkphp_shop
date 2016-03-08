<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - <?php echo ($meta_title); ?> </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="http://admin.shop.com/Public/IMG/top_loader.gif" type="image/x-icon">
<link href="http://admin.shop.com/Public/CSS/general.css" rel="stylesheet" type="text/css" />
<link href="http://admin.shop.com/Public/CSS/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('index');?>">文章列表</a></span>
    <span class="action-span1"><a href="<?php echo U('Index/main');?>">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($meta_title); ?> </span>
    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form method="post" action="<?php echo U('');?>" enctype="multipart/form-data" >
        <table cellspacing="1" cellpadding="3" width="100%">
            <input type="hidden" name="id" value="<?php echo ($row["id"]); ?>" />
            <input type="hidden" name="intro" value="" />
            <tr>
                <td class="label">文章名称</td>
                <td>
                    <input type="text" name="name" maxlength="60" value="<?php echo ($row["name"]); ?>" />
                    <span class="require-field">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">文章分类</td>
                <td>
                    <select class="article_category_id" name="article_category_id">
                        <option >请选择</option>
                        <?php if(is_array($cates)): foreach($cates as $key=>$cate): ?><option value="<?php echo ($cate["id"]); ?>"><?php echo ($cate["catename"]); ?></option><?php endforeach; endif; ?>

                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">文章内容</td>
                <td>
                    <textarea  name="content" cols="60" rows="4"  ><?php echo ($info["content"]); ?></textarea>
                </td>
            </tr>
            <tr>
                <td class="label">排序</td>
                <td>
                    <input type="text" name="sort" maxlength="40" size="15" value="<?php echo ((isset($row["sort"]) && ($row["sort"] !== ""))?($row["sort"]):50); ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">是否显示</td>
                <td>
                    <input type="radio" name="status" value="1" checked="checked" /> 是
                    <input type="radio" name="status" value="0"  /> 否(当品牌下还没有商品的时候，首页及分类页的品牌区将不会显示该品牌。)
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><br />
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript" src="http://admin.shop.com/Public/JS/jquery-1.11.2.js"></script>
<script type="text/javascript" >
    $(function(){
        if(<?php echo ($row); ?>){
            $(':input[name=status]').val([<?php echo ($row["status"]); ?>]);
            $('.article_category_id').val([<?php echo ($row["article_category_id"]); ?>]);
        };


    });
</script>
<div id="footer">
共执行 1 个查询，用时 0.018952 秒，Gzip 已禁用，内存占用 2.197 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>