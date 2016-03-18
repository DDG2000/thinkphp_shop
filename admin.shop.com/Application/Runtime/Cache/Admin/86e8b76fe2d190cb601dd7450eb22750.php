<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: category_info.htm 16752 2009-10-20 09:59:38Z wangleisvn $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>ECSHOP 管理中心 - <?php echo ($meta_title); ?> </title>
        <meta name="robots" content="noindex, nofollow"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="http://admin.shop.com/Public/CSS/general.css" rel="stylesheet" type="text/css" />
        <link href="http://admin.shop.com/Public/CSS/main.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="http://admin.shop.com/Public/EXT/ztree/css/zTreeStyle/zTreeStyle.css" />
    </head>
    <body>
        <h1>
            <span class="action-span"><a href="<?php echo U('index');?>">管理员管理</a></span>
            <span class="action-span1"><a href="<?php echo U('Index/main');?>">ECSHOP 管理中心</a></span>
            <span id="search_id" class="action-span1"> - <?php echo ($meta_title); ?> </span>
        </h1>
        <div style="clear:both"></div>
        <div class="main-div">
            <form action="<?php echo U();?>" method="post" name="theForm">
                <table width="100%" id="general-table">
                    <tr>
                        <td class="label">管理员名:</td>
                        <td>
                            <?php if(empty($row)): ?><input type='text' name='username' maxlength="20" value='<?php echo ($row["username"]); ?>' size='27' /> <font color="red">*</font>
                            <?php else: ?>
                            <?php echo ($row["username"]); endif; ?>
                        </td>
                    </tr>
                    <?php if(empty($row)): ?><tr>
                        <td class="label">密码:</td>
                        <td>
                            <input type='password' name='password' maxlength="20" value='<?php echo ($row["password"]); ?>' size='27' /> <font color="red">*</font>
                        </td>
                    </tr><?php endif; ?>
                    <tr>
                        <td class="label">email:</td>
                        <td>
                            <?php if(empty($row)): ?><input type="text" name='email'  value="<?php echo ($row["email"]); ?>" size="27" />
                            <?php else: echo ($row["email"]); endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">角色:</td>
                        <td>
                            <?php if(is_array($roles)): foreach($roles as $key=>$role): ?><label><input type="checkbox" name="role_id[]" value="<?php echo ($role["id"]); ?>" <?php if(in_array($role['id'],$row['roles'])): ?>checked='checked'<?php endif; ?>/><?php echo ($role["name"]); ?></label><?php endforeach; endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">拥有权限:</td>
                        <td>
                            <div id="permission_ids"></div>
                            <ul id="treeDemo" class="ztree"></ul>
                        </td>
                    </tr>
                </table>
                <div class="button-div">
                    <input type="hidden" name="id" value="<?php echo ($row["id"]); ?>" />
                    <input type="submit" value=" 确定 " />
                    <input type="reset" value=" 重置 " />
                </div>
            </form>
        </div>

        <div id="footer">
            共执行 3 个查询，用时 0.162348 秒，Gzip 已禁用，内存占用 2.266 MB<br />
            版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
        <script type="text/javascript" src="http://admin.shop.com/Public/JS/jquery-1.11.2.js"></script>
        <script type="text/javascript" src="http://admin.shop.com/Public/EXT/ztree/js/jquery.ztree.core.min.js"></script> 
        <script type="text/javascript" src="http://admin.shop.com/Public/EXT/ztree/js/jquery.ztree.excheck.js"></script> 
        <script type="text/javascript">
            $(document).ready(function () {
                //默认选中[是否显示]
                $(':input[name=status]').val([<?php echo ((isset($row["status"]) && ($row["status"] !== ""))?($row["status"]):1); ?>]);
                
                //准备节点数据
                var zNodes = <?php echo ($permissions); ?>;
                //基本配置
                var setting = {
                    check: {
                        enable: true,
                        checkboxType:{ "Y" : "ps", "N" : "ps" },
                    },
                    data: {
                        simpleData: {
                            enable: true,
                            pIdKey: "parent_id",
                        }
                    },
                    callback:{
                        onCheck:function(event,treeid,tree_node){
                            var checked_nodes = ztree_obj.getCheckedNodes(true);
                            var ele = $('#permission_ids');
                            //清空隐藏域
                            var html = '';
                            $(checked_nodes).each(function(){
                                var check_status = this.getCheckStatus();
                                //忽略半选的节点
                                if(!check_status.half){
                                    html += '<input type="hidden" name="permission_id[]" value="'+this.id+'"/>';
                                }
                            });
                            ele.html(html);
                        },
                    },
                };
                //将html节点初始化成ztree的效果
                var ztree_obj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
                
                
                //编辑页面的时候,找到父级节点,并且回显出来
                <?php if(!empty($row["id"])): ?>//选中关联的权限列表
                    var checked_nodes = <?php echo ($row["permission_id"]); ?>;
                    console.debug(checked_nodes);
                    $(checked_nodes).each(function(i,n){
                            var tree_node = ztree_obj.getNodeByParam('id',n);
                            ztree_obj.checkNode(tree_node,true,true,true);
                        }
                    );<?php endif; ?>
        
                //展开所有的ztree节点
                ztree_obj.expandAll(false);
            });
        </script>
    </body>
</html>