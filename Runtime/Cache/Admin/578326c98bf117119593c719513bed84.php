<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=">
<title>后台管理系统</title>
<link rel="stylesheet" href="/hg_2016/Public/Admin/css/css.css">
<script src="/hg_2016/Public/Admin/js/jquery-1.9.1.js"></script>
<script src="/hg_2016/Public/Common/Layer/layer.js"></script>
</head>
<body>


<div class="nav">
	<div class="nav_title">
    	<h4><img class="nav_img" src="/hg_2016/Public/Admin/img/tab.gif" /><span class="nav_a">日志管理</span></h4>
    </div>
</div>


<div class="list">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_table">
		  <form name="searchform" method="get" action="">
			  <select name="member1">
				  <option value="">选择条件</option>
				  <option value="account" <?php if(I('member1') == 'account'): ?>selected="selected"<?php endif; ?>>登录名</option>
				  <option value="operation_details" <?php if(I('member1') == 'operation_details'): ?>selected="selected"<?php endif; ?>>操作详情</option>
			  </select>
			  <input type="text" name="textsearcherkeywords" value="<?php echo I('textsearcherkeywords');?>" />
			  <input name="sousuo" type="submit" value="搜索" class="imgbtn" />
		  </form>
      <thead>
	    <tr>
	      <td width="7%"><div align="center">ID</div></td>
	      <td width="12%"><div align="center">用户名</div></td>
	      <td width="9%"><div align="center">操作详情</div></td>
	      <td width="10%"><div align="center">登录IP</div></td>
	      <td width="13%"><div align="center">操作时间</div></td>
	      <td width="9%"><div align="center">日志数据</div></td>
	      <td width="16%"><div align="center">操作</div></td>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($list)): $id = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($id % 2 );++$id;?><tr id="del<?php echo ($vo["id"]); ?>">
			<td height="50">
				<div align="center">
				<?php $p=I('p')?I('p'):1; echo (($p-1)*15+$id); ?>
				</div>
			</td>
			<td><div align="center"><?php echo ($vo["account"]); ?></div></td>
			<td><div align="center"><?php echo ($vo["operation_details"]); ?></div></td>
			<td><div align="center"><?php echo ($vo["login_ip"]); ?></div></td>
			<td><div align="center"><?php echo (date("Y-m-d H:i:s",$vo["operation_time"])); ?></div></td>
			<td><div align="center"><?php echo ($vo["log_data"]); ?></div></td>
			<td>
				<div align="center">
					<a href="/hg_2016/Admin/Admin/delete?id=<?php echo ($vo["id"]); ?>" onclick="return confirm('您确定要删除吗？')" target="_self">删除</a>
				</div>
			</td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
  </table>
</div>

<!-- 分页 -->
<div class="page">
<?php echo ($page); ?>
</div>


</body>
</html>