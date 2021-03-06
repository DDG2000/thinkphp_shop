<?php if (!defined('THINK_PATH')) exit();?><!-- $Id: brand_info.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--标题-->
    <title>ECSHOP 管理中心 - <?php echo ($meta_title); ?> </title>
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!--标题前icon-->
    <link rel="shortcut icon" href="http://admin.shop.com/Public/IMG/top_loader.gif" type="image/x-icon">
    <link href="http://admin.shop.com/Public/CSS/general.css" rel="stylesheet" type="text/css"/>
    <link href="http://admin.shop.com/Public/CSS/main.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="http://admin.shop.com/Public/CSS/upload.css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('index');?>">商品品牌</a></span>
    <span class="action-span1"><a href="<?php echo U('Index/main');?>">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo ($meta_title); ?> </span>

    <div style="clear:both"></div>
</h1>
<div class="main-div">
    <!--enctype="multipart/form-data"可以提交文件-->
    <form method="post" action="<?php echo U('');?>" enctype="multipart/form-data">
        <table cellspacing="1" cellpadding="3" width="100%">
            <!--添加品牌提交时为空，作用在编辑回显时有值，提供id被提交-->
            <input type="hidden" name="id" value="<?php echo ($row["id"]); ?>"/>
            <tr>
                <td class="label">品牌名称</td>
                <td>
                    <input type="text" name="name" maxlength="60" value="<?php echo ($row["name"]); ?>"/>
                    <span class="require-field">*</span>
                </td>
            </tr>
            <!--<?php if(!empty($row["url"])): ?>-->
            <tr>
                <td class="label">品牌网址</td>
                <td>
                    <input type="text" name="url" maxlength="60" size="40" value="<?php echo ($row["url"]); ?>"/>
                </td>
            </tr>
            <!--<?php endif; ?>-->
            <tr>
                <td class="label">品牌LOGO</td>
                <td>
                    <input type="hidden" name="logo[]" value="<?php echo ($row["logo"]); ?>" id="logo"><br/>
                    <input type="file"  id="file_upload" name="file_upload" multiple="true"><br/>
                    <span class="notice-span" style="display:block" id="warn_brandlogo">请上传图片，做为品牌的LOGO！</span>
                    <?php if(!empty($row["id"])): ?><img src="<?php echo ($row["logo"]); ?>" id="logo_preview"><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="label">品牌描述</td>
                <td>
                    <textarea name="intro" cols="60" rows="4"><?php echo ($row["intro"]); ?></textarea>
                </td>
            </tr>
            <tr>
                <td class="label">排序</td>
                <td>
                    <input type="text" name="sort" maxlength="40" size="15" value="<?php echo ((isset($row["sort"]) && ($row["sort"] !== ""))?($row["sort"]):50); ?>"/>
                </td>
            </tr>
            <tr>
                <td class="label">是否显示</td>
                <td>
                    <input type="radio" name="status" value="1" checked="checked"/> 是
                    <input type="radio" name="status" value="0"/> 否(当品牌下还没有商品的时候，首页及分类页的品牌区将不会显示该品牌。)

                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"><br/>
                    <input type="submit" class="button" value=" 确定 "/>
                    <input type="reset" class="button" value=" 重置 "/>
                </td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript" src="http://admin.shop.com/Public/JS/jquery-1.11.2.js"></script>
<script type="text/javascript" src="http://admin.shop.com/Public/EXT/uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript" src="http://admin.shop.com/Public/EXT/layer/layer.js"></script>
<script type="text/javascript">
    $(function () {
        $(':input[name=status]').val([<?php echo ((isset($row["status "]) && ($row["status "] !== ""))?($row["status "]): 1); ?>]);//状态单选框赋值,回显选中
        $('#file_upload').uploadify({
            'swf'      : 'http://admin.shop.com/Public/EXT/uploadify/uploadify.swf',
            'uploader' : '<?php echo U("Upload/index");?>', //上传控制器
            'fileObjName':'logo',    //上传文件名
            'buttonText':'上传',       //更改按键字
//            'multi':false,        //批量上传
            'overrideEvents':['onUploadSuccecc','onUploadError'],   //重写回调函数
            'onUploadError':function(file,errorCode,errorMsg,errorString){
                console.debug(arguments);
            },

            'onUploadSuccess':function(file,data,response){     //执行成功回调函数
//                data是字符串,要转jason对象
                data= $.parseJSON(data);                 //见data转换成json对象
                console.debug(data);
                $('#logo_preview').val(data.url);
                if(data.status){                            //判断接送中status值
                    $('#logo').val(data.file_url);          //status成立则给logo标签赋值地址
                }else{                                          //不成立返回错误信息
                    alert(data.msg);
                }
                 console.debug(data);
            }
        });
    });
</script>
<div id="footer">
    共执行 1 个查询，用时 0.018952 秒，Gzip 已禁用，内存占用 2.197 MB<br/>
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。
</div>
</body>
</html>