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
function check(){
	var title = $('#title').val();
	var name = $('#name').val();
	if(title == ''){
		layer.tips('请输入名称', '#title',{tips:1,time: 10000});
		return false;
	}
	if(name == ''){
		layer.tips('请输入（控制器/方法）', '#name',{tips:1,time: 10000});
		return false;
	}
	if(name.indexOf('/') <=0 ){
		layer.tips('格式必须为（控制器/方法）', '#name',{tips:[1, '#78BA32'],time: 10000});
		return false;
	}
	return true;
}
</script>
<script>
function rule_edit(){
	parent.layer.open({
		type: 2,
		closeBtn: 2,
		area: ['470px', '350px'],
		title: '编辑权限',
		content: '../Admin/rule_edit.html'
	});	
}
</script>
</head>
<body>


<div class="nav">    
    <div class="nav_title">
    	<h4><img class="nav_img" src="/hg_2016/Public/Admin/img/tab.gif" /><span class="nav_a">内容管理</span></h4>
    </div>
</div>

<form name="myform" action="/hg_2016/Admin/Admin/auth_rule?menu_title=%E7%B3%BB%E7%BB%9F%E7%AE%A1%E7%90%86%20-%3E%20%E6%9D%83%E9%99%90%E8%8F%9C%E5%8D%95" method="post" onsubmit="return check(this)">
<div class="table_top">
父级：<select name="pid">
  		<option value="">--------- 顶级 ---------</option>
    <?php if(is_array($data)): foreach($data as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></option><?php endforeach; endif; ?>
  </select>
名称：<input type="text" name="title" id="title" class="input" />
控制器/方法：<input type="text" name="name" id="name" class="input" />
<button type="submit" id="submit" class="button">添 加</button>

（ 为防止误操作，请在数据库编辑/删除操作 ）
</div>
</form>

<div class="list">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_table">
      <thead>
	    <tr>
	      <td width="13%"><div align="center"><button type="button" id="button" class="button">修改排序</button></div></td>
	      <td width="12%"><div align="center">ID</div></td>
	      <td width="25%"><div align="center">名称</div></td>
	      <td width="25%"><div align="center">控制器/方法</div></td>
	      <td width="25%"><div align="center">创建时间</div>	        <div align="center"></div>	        <div align="center"></div></td>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($data)): foreach($data as $key=>$vo): ?><tr>
	      <td><div align="center"><input type="text" style="width:40px;height:24px;padding-left:10px;margin-right:30px;" value="<?php echo ($vo["sort"]); ?>"></div></td>
	      <td height="45"><div align="center"><?php echo ($vo["id"]); ?></div></td>
	      <td><div style="padding-left:50px;"><?php echo ($vo["title"]); ?></div>
          </td>
	      <td><div style="padding-left:50px;"><?php echo ($vo["name"]); ?></div></td>
	      <td><div align="center"><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></div></td>
	      </tr>
          	  <?php if(is_array($vo['sub'])): foreach($vo['sub'] as $key=>$sub): ?><tr>
                    <td><div align="center"><input type="text" style="width:40px;height:24px;padding-left:10px;margin-left:20px;" value="<?php echo ($vo["sort"]); ?>"></div></td>
                      <td height="45"><div align="center"><?php echo ($sub["id"]); ?></div></td>
                      <td><div style="padding-left:50px;">&nbsp;&nbsp;&nbsp;&nbsp;┠─&nbsp;&nbsp;<?php echo ($sub["title"]); ?></div></td>
                      <td><div style="padding-left:100px;"><?php echo ($sub["name"]); ?></div></td>
                      <td><div align="center"><?php echo (date("Y-m-d H:i:s",$sub["create_time"])); ?></div></td>
                  </tr><?php endforeach; endif; endforeach; endif; ?>
        </tbody>
  </table>
</div>

<!-- 分页 -->
<div class="page">
  <div align="center"><?php echo ($page); ?> </div>
</div>


</body>
</html>