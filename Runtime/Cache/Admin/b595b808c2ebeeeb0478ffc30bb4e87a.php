<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=">
<title>后台管理系统</title>
<link rel="stylesheet" href="/hg_2016/Public/Admin/css/css.css">
<script src="/hg_2016/Public/Admin/js/jquery-1.9.1.js"></script>
<script src="/hg_2016/Public/Admin/js/base.js"></script>
<script src="/hg_2016/Public/Common/Layer/layer.js"></script>
<script>
//退出登录
function logout(){
	layer.confirm('你确定要退出吗？', {icon: 3}, function(index){
	    layer.close(index);
	    window.location.href="<?php echo U('Index/logout');?>";
	});
}


</script>
</head>
<body style="min-width:1100px; overflow:hidden;">
<!--header -->
<div class="header">
	<div class="logo"><div class="logo_img"><img src="/hg_2016/Public/Admin/img/logo.png"></div></div>
    <div class="top">	
        <div class="top_link">
            <div style="line-height:35px; float:left; margin-right:20px;">
            您好 [ &nbsp;&nbsp;<a style="color:#00F; font-size:18px;" target="iframe" ><?php echo ($_SESSION['account']); ?></a> &nbsp;&nbsp;] ，欢迎回来！
            </div>
            <ul>
                <li class="top_link_left"></li>
                <li class="top_link_bg"><a class="annex" href="javascript:;" onclick="update_pwd();">密码修改</a></li>
                <li class="top_link_bg"><a class="annex" href="javascript:;" onclick="clear_cache();">清除缓存</a></li>
                <li class="top_link_bg"><a class="annex" href="javascript:;" onclick="return logout();">退出</a></li>
                <li class="top_link_right"></li>
            </ul>
        </div>
        <div class="clear"></div>
        <div class="menu">
            <ul>
            	<?php if(is_array($data)): foreach($data as $key=>$vo): ?><li><a href="/hg_2016/Admin/<?php echo ($vo["default_name"]); ?>?menu_title=<?php echo (urlencode($vo['title'])); ?> -> <?php echo (urlencode($vo['default_title'])); ?>" target="iframe" id="menu_hover<?php echo ($vo["id"]); ?>" onclick="change_menu(<?php echo ($vo["id"]); ?>)"><?php echo ($vo["title"]); ?></a></li><?php endforeach; endif; ?>
            </ul>
        </div>
    </div>
</div>

<!--left 此处的sub_menu_a+id   以及  change_sub_menu+id  (id为不重复的数字)  必须存在，否则菜单栏会出错 -->
<div class="left" id="left_sub_menu">
	<input type="hidden" name="right_show" id="right_show" value="1" />
    <!-- <div class="sub_menu_title">客户管理</div> -->
    <?php if(is_array($data)): foreach($data as $key=>$vo): ?><ul class="sub_menu" id="sub_menu<?php echo ($vo['id']); ?>" style="display:none;">
    	<?php if(is_array($vo['sub'])): foreach($vo['sub'] as $k=>$sub): if($k == 0): ?><li><a id="sub_menu_<?php echo ($sub['id']); ?>" onclick="change_sub_menu(<?php echo ($sub['id']); ?>)" href="/hg_2016/Admin/<?php echo ($sub['name']); ?>?menu_title=<?php echo ($vo['title']); ?> -> <?php echo (urlencode($sub['title'])); ?>" target="iframe" class="sub_menu_hover"><?php echo ($sub['title']); ?></a></li>
    		<?php else: ?>
    <li><a id="sub_menu_<?php echo ($sub['id']); ?>" onclick="change_sub_menu(<?php echo ($sub['id']); ?>)" href="/hg_2016/Admin/<?php echo ($sub['name']); ?>?menu_title=<?php echo ($vo['title']); ?> -> <?php echo (urlencode($sub['title'])); ?>" target="iframe"><?php echo ($sub['title']); ?></a></li><?php endif; endforeach; endif; ?>
    </ul><?php endforeach; endif; ?>
    <div class="web_info">后台管理系统</div>
</div>

<!-- split_line -->
<div class="split_line" id="left_hidden">
	<div class="left_hidden botton_left_hover"></div>
</div>

<!-- right -->
<div class="right">
<iframe frameborder="0" id="iframe" name="iframe" style="min-width:850px;" src="<?php echo U('Member/member_list');?>"></iframe>
</div>


</body>
</html>