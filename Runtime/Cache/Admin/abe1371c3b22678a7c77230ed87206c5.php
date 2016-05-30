<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=">
<title>经纪人管理</title>
<link rel="stylesheet" href="/hg_2016/Public/Admin/css/css.css">
<script src="/hg_2016/Public/Admin/js/jquery-1.9.1.js"></script>
<script src="/hg_2016/Public/Common/Layer/layer.js"></script>
    <script src="/hg_2016/Public/Common/My97Date/WdatePicker.js"></script>
<script>
//添加用户
function add(){
    parent.layer.open({
        type: 2,
        shadeClose: true,
        shade: 0.5,
        area: ['850px', '840px'],
        title: '添加用户',
        content: '<?php echo U("Admin/agent_add");?>'
    });
}
//导入excel用户
function addagent_excel(){
    parent.layer.open({
        type: 2,
        shadeClose: true,
        shade: 0.5,
        area: ['350px', '500'],
        title: '导入用户',
        content: '<?php echo U("Admin/addagent_excel");?>'
    });
}
//导出excel用户
//离职
function out(id){
    parent.layer.open({
        type: 2,
        shadeClose: true,
        shade: 0.5,
        area: ['500px', '500px'],
        title: '离职',
        content: '<?php echo U("Admin/agent_out");?>?id='+id
    });
}

//编辑用户
function edit(id){
    parent.layer.open({
        type: 2,
        shadeClose: true,
        shade: 0.5,
        area: ['850px', '840px'],
        title: '编辑账号信息',
        content: '<?php echo U("Admin/agent_edit");?>?id='+id
    });
}
function subform(i) {

    var theform=document.form_do;
    theform.action=i;
    theform.submit();
}


function selectall(whosform){
    for(var i=0;i<whosform.elements.length;i++){
        var box = whosform.elements[i];
        if (box.name != 'chkall')
            box.checked = whosform.chkall.checked;
    }
}

</script>
    <script>
        //弹出搜索框

                $(document).ready(function(){
                    //排序
                    $("#orderdown").click(function(){
                        $("#order").val('groupname asc');
                        $("form.formSo").submit();

                    });
                    $("#orderup").click(function(){
                        $("#order").val('groupname desc');
                        $("form.formSo").submit();

                    });
                    $("#departmentdown").click(function(){
                        $("#order").val('department asc');
                        $("form.formSo").submit();

                    });
                    $("#departmentup").click(function(){
                        $("#order").val('department desc');
                        $("form.formSo").submit();

                    });

                    $("#group").click(function(){
                       $("#shai_x").show();
                        });
    });

        function selectall(whosform){
            for(var i=0;i<whosform.elements.length;i++){
                var box = whosform.elements[i];
                if (box.name != 'chkall')
                    box.checked = whosform.chkall.checked;
            }
        }

</script>

</head>
<body>


<div class="nav">
    <div class="nav_title">
        <h4><img class="nav_img" src="/hg_2016/Public/Admin/img/tab.gif" /><span class="nav_a" style="margin-left:10px;">经纪人列表</span><span class="nav_a"><a href="<?php echo U('Admin/agents_out');?>">经纪人离职列表</a></span></h4>
    </div>
    <div class="nav_title" id="shai_x">
    <form name="form1" class="formSo" method="get" action="<?php echo U('Admin/agent_list');?>">
        <input name="keyword" type="hidden" id="keyword" value="" class="s26" />
        <input name="sx" type="hidden" id="sx" value="" class="s26" />
        <input name="order" type="hidden" id="order" value="" class="s26" />
        <input type="submit" id="tj" class="btn btn-danger btn-sm" value="">&nbsp;
    </form>
    </div>
    <div class="nav_title" id="paixu">
        <form name="form3" class="formPx" method="get" action="<?php echo U('Admin/agent_list');?>">
            <input name="order" type="hidden" id="order" value="" class="s26" />


            <input type="submit" id="pxtj" class="btn btn-danger btn-sm" value="">&nbsp;
        </form>
    </div>
    <?php if( $_SESSION['aid'] == 1): ?><div class="nav_button">
        <a href="javascript:;" onclick="add();"><button class="button">+ 添加经纪人</button></a>
        <a href="javascript:;" onclick="addagent_excel();"><button class="button">+ 导入经纪人</button></a>
    </div><?php endif; ?>
</div>


<div class="list">
      <table width="1800px" border="0" cellpadding="0" cellspacing="0" class="list_table">
          <form name="searchform" method="get" action="">
              <select name="member">
                  <option value="">选择条件</option>
                  <option value="agentname" <?php if(I('member') == 'agentname'): ?>selected="selected"<?php endif; ?>>经纪人</option>
                  <option value="groupname" <?php if(I('member') == 'groupname'): ?>selected="selected"<?php endif; ?>>小组</option>
                  <option value="department" <?php if(I('member') == 'department'): ?>selected="selected"<?php endif; ?>>部门</option>
              </select>
              <input type="text" name="textsearcherkeywords" value="<?php echo I('textsearcherkeywords');?>" />
                <input name="sousuo" type="submit" value="搜索" class="imgbtn" />
          </form>
          <form action="/hg_2016/Admin/Admin/edit_mul" method="post" id="form2">
      <thead>
      <tr class="action">
          <td width="1%"><div align="center"><input  name="chkall" type="checkbox" id="chkall" onclick="selectall(this.form)"></div></td>
          <td width="1%" id="add1"><div align="center">ID</div></td>
          <td width="2%"><div align="center">工号</div></td>
          <td width="2%"><div align="center">经纪人姓名</div></td>
          <td width="1%"><div align="center">身份证号</div></td>
          <td width="1%"><div align="center">电话</div></td>
          <td width="3%"><div align="center">小组</div></td>
          <td width="1%"><div align="center">部门</div></td>
          <td width="4%"><div align="center">操作</div></td>
      </tr>
        </thead>
        <tbody>

        <?php if(is_array($lists)): foreach($lists as $key=>$vo): ?><!--<?php if($vo["cong"] == 1 or $vo["cong1"] == 1): ?>-->
                <!--<tr id="del<?php echo ($vo["id"]); ?>" class="list" align="center" bgcolor="#ffe4c4">-->
                    <!--<?php else: ?>-->
                <!--<tr id="del<?php echo ($vo["id"]); ?>" class="list" align="center">-->
            <!--<?php endif; ?>-->
            <tr id="del<?php echo ($vo["id"]); ?>">
                <td>
                    <div align="center"><input type="checkbox" name="user_id[]" value="<?php echo ($vo["id"]); ?>"></div>
                </td>
                <td height="40" id="add">
                    <div align="center" id="id"><?php echo ($vo["id"]); ?></div>
                </td>
               <td>
                <div align="center"><?php echo ($vo["jobnumber"]); ?></div>
               </td>
                <td>
                    <div align="center"><?php echo ($vo["agentname"]); ?></div>
                </td>
                <td>
                    <?php if($vo["cong1"] == 1): ?><div align="center" style="background-color:#FFF68F"><?php echo ($vo["codeid"]); ?></div>
                        <?php else: ?>
                        <div align="center"><?php echo ($vo["codeid"]); ?></div><?php endif; ?>
                </td>
                <td>
                    <div align="center"><?php echo ($vo["tel"]); ?></a>
                    </div>
                </td>
                <td>
                    <div align="center"><?php echo ($vo["groupname"]); ?></div>
                </td>
                <td>
                    <div align="center"><?php echo ($vo["department_x"]); ?></div>
                </td>
                <td><div align="center">
                    <a class="a_button" href="javascript:;" onClick="out(<?php echo ($vo["id"]); ?>);">离职</a>
                <a class="a_button" href="javascript:;" onClick="edit(<?php echo ($vo["id"]); ?>);">编辑</a>
            </div></td>
            </tr><?php endforeach; endif; ?>
        </tbody>
          </form>
  </table>
</div>

<!-- 分页 -->
<div class="page">
<?php echo ($page); ?>
</div>


</body>
</html>