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
//删除
function del(id){
	$("#del"+id+" td").css('background','#CBDFF2');
	parent.layer.confirm('请确认该组下已经没有组成员了，否则需要重新授权，真的要删除吗？', {
		btn: ['是的','取消'], //按钮
		shade: 0.5
	}, function(){
		$.post("<?php echo U('Admin/group_del');?>", { "id": id },function(data){
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
    	<h4><img class="nav_img" src="/hg_2016/Public/Admin/img/tab.gif" /><span class="nav_a">添加用户组</span></h4>
    </div>
    <div class="nav_button">
    	<a href="<?php echo U('Admin/group_add');?>"><button class="button">+ 添加用户组</button></a>
    </div>
</div>
<div class="list">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_table">
      <thead>
	    <tr>
	      <td width="14%"><div align="center">ID</div></td>
	      <td width="23%"><div align="center">角色/组</div></td>
	      <td width="34%"><div align="center">创建时间</div></td>
	      <td width="29%"><div align="center">操作</div></td>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($data)): foreach($data as $key=>$vo): ?><tr id="del<?php echo ($vo["id"]); ?>">
	      <td height="50"><div align="center"><?php echo ($vo["id"]); ?></div></td>
	      <td><div align="center"><?php echo ($vo["title"]); ?></div></td>
	      <td><div align="center"><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></div></td>
	      <td><div align="center"><a class="a_button" name="edit" href="<?php echo U('Admin/group_edit',array('id'=>$vo[id]));?>">授权 / 编辑</a>
          <a class="a_button" href="javascrip:;" name="del" onclick="del(<?php echo ($vo["id"]); ?>);">删除</a></div></td>
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