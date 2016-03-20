<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: category_info.htm 16752 2009-10-20 09:59:38Z wangleisvn $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ECSHOP 管理中心 - <?php echo ($meta_title); ?> </title>
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="http://admin.shop.com/Public/CSS/general.css" rel="stylesheet" type="text/css"/>
    <link href="http://admin.shop.com/Public/CSS/main.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('index');?>">商品分类</a></span>
    <span class="action-span1"><a href="<?php echo U('Index/main');?>">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($meta_title); ?> </span>

    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <form action="<?php echo U('');?>" method="post" name="theForm">
        <table width="100%" id="general-table">
            <tr>
                <td class="label">分类名称:</td>
                <td>
                    <input type='text' name='name' maxlength="20" value='<?php echo ($data["name"]); ?>' size='27'/> <font color="red">*</font>
                </td>
            </tr>
            <tr>
                <td class="label">上级分类:</td>
                <td>
                    <input type='text' name='parent_name'  id="parent_name" disabled="disabled"/>
                    <ul style="border: 1px solid #ccc;width:183px" id="tree" class="ztree"></ul>
                    <input type="hidden" name="parent_id" id="parent_id" value=""/>
                </td>
            </tr>
            <tr>
                <td class="label">排序:</td>
                <td>
                    <input type="text" name='sort' value="<?php echo ((isset($data["sort"]) && ($data["sort"] !== ""))?($data["sort"]):50); ?>" size="15"/>
                </td>
            </tr>

            <tr>
                <td class="label">是否显示:</td>
                <td>
                    <input type="radio" name="status" value="1" checked="true"/> 是
                    <input type="radio" name="status" value="0"/> 否
                </td>
            </tr>
            <tr>
                <td class="label">简介:</td>
                <td>
                    <textarea name="intro" value='<?php echo ($data["intro"]); ?>'></textarea>
                </td>
            </tr>
        </table>
        <div class="button-div">
            <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>">
            <input type="submit" value=" 确定 "/>
            <input type="reset" value=" 重置 "/>
        </div>
    </form>
</div>

<div id="footer">
    共执行 3 个查询，用时 0.162348 秒，Gzip 已禁用，内存占用 2.266 MB<br/>
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。
</div>
<link rel="stylesheet" type="text/css" href="http://admin.shop.com/Public/EXT/ztree/css/zTreeStyle/zTreeStyle.css" />
<script type="text/javascript" src="http://admin.shop.com/Public/JS/jquery-1.11.2.js"></script>
<script type="text/javascript" src="http://admin.shop.com/Public/EXT/ztree/js/jquery.ztree.core.js"></script>

<script type="text/javascript">

    var setting = {
        data: {
            simpleData: {     //参数配置
                enable: true,
                pIdKey: "parent_id",
            }
        },
        callback: {       //回调函数
            onClick: function(event, treeId, treeNode){
                console.debug(treeNode);
                $('#parent_id').val(treeNode.id);      //返回id
                $('#parent_name').val(treeNode.name);  //返回父级名
            }
        }
    };
    var zNodes =<?php echo ($rows); ?>;
    $(function(){
    $(':input[name=status]').val([<?php echo ((isset($data["status "]) && ($data["status "] !== ""))?($data["status "]): 1); ?>]);//状态单选框赋值,回显选中
        $obj=$.fn.zTree.init($("#tree"), setting, zNodes);
        $obj.expandAll(false);        //默认全展开
        <?php if(!empty($data["id"])): ?>var parent_node=$obj.getNodeByParam("id", <?php echo ($data["parent_id"]); ?>);
        $obj.selectNode(parent_node);
        $('#parent_id').val(parent_node.id);
        $('#parent_name').val(parent_node.name);<?php endif; ?>
    });
</script>
</body>
</html>