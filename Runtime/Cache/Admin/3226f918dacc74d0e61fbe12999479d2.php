<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=">
<title>后台管理系统</title>
<link rel="stylesheet" href="/hg_2016/Public/Admin/css/css.css">
<script src="/hg_2016/Public/Admin/js/jquery-1.9.1.js"></script>
<script src="/hg_2016/Public/Common/Layer/layer.js"></script>
<script>
//添加用户
function add(){
	parent.layer.open({
		type: 2,
		shadeClose: true,
		shade: 0.5,
		area: ['450px', '340px'],
		title: '添加用户',
		content: '<?php echo U("Admin/admin_add");?>'
	});
}

//编辑用户
function edit(id){
	parent.layer.open({
		type: 2,
		shadeClose: true,
		shade: 0.5,
		area: ['450px', '340px'],
		title: '编辑账号信息',
		content: '<?php echo U("Admin/admin_edit");?>?id='+id
	});
}

//删除用户
function del(id){
	$("#del"+id+" td").css('background','#CBDFF2');
	parent.layer.confirm('真的要删除吗？', {
		btn: ['确认','取消'], //按钮
		shade: 0.5 //显示遮罩
	}, function(){
		$.post("<?php echo U('Admin/admin_del');?>", { "id": id},function(data){
			if(data == 1){
				parent.layer.msg('删除成功', { icon: 1, time: 1000 }, function(){
						$("#del"+id).remove();
					});
			}else{
				parent.layer.msg('删除失败', {icon: 2, time: 2000 }); 
			}
		}, "json");
	},function(){
		$("#del"+id+" td").css('border-top','0');
		$("#del"+id+" td").css('border-bottom','1px solid #EFEFEF');
	});
}
</script>
</head>
<body>


<div class="nav">
	<div class="nav_title">
    	<h4><img class="nav_img" src="/hg_2016/Public/Admin/img/tab.gif" /><span class="nav_a">管理员列表</span></h4>
    </div>
    <?php if( $_SESSION['aid'] == 1): ?><div class="nav_button">
    	<a href="javascript:;" onclick="add();"><button class="button">+ 添加用户</button></a>
    </div><?php endif; ?>
</div>


<div class="list">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_table">
      <thead>
	    <tr>
	      <td width="7%"><div align="center">ID</div></td>
	      <td width="12%"><div align="center">用户名</div></td>
	      <td width="9%"><div align="center">所属分组</div></td>
	      <td width="10%"><div align="center">最近登录IP</div></td>
	      <td width="13%"><div align="center">最近登录时间</div></td>
	      <td width="9%"><div align="center">登录次数</div></td>
	      <td width="9%"><div align="center">状态</div></td>
	      <td width="15%"><div align="center">创建时间</div></td>
	      <td width="16%"><div align="center">操作</div></td>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($data)): foreach($data as $key=>$vo): ?><tr id="del<?php echo ($vo["id"]); ?>">
	      <td height="40"><div align="center"><?php echo ($vo["id"]); ?></div></td>
	      <td><div align="center"><?php echo ($vo["account"]); ?></div></td>
	      <td><div align="center"><?php echo ($vo["group"]); ?></div></td>
	      <td><div align="center"><?php echo ($vo["login_ip"]); ?></div></td>
	      <td><div align="center"><?php if( !empty($vo['login_time']) ): echo (date("Y-m-d H:i:s",$vo["login_time"])); endif; ?></div></td>
	      <td><div align="center"><?php echo ($vo["login_count"]); ?></div></td>
	      <td><div align="center"><?php if( $vo["status"] == 1 ): ?>已启用<?php else: ?><span style="color:#F00">已禁用</span><?php endif; ?></div></td>
	      <td><div align="center"><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></div></td>
	      <td><div align="center"><?php if($vo['id'] != 1): ?><a class="a_button" href="javascript:;" onClick="edit(<?php echo ($vo["id"]); ?>);">编辑</a>
          <a class="a_button" href="javascript:;" onclick="del(<?php echo ($vo[id]); ?>)">删除</a><?php endif; ?>
          </div></td>
        </tr><?php endforeach; endif; ?>
        </tbody>
  </table>
</div>

<!-- 分页 -->
<div class="page">
<?php echo ($page); ?>
</div>


</body>
</html>