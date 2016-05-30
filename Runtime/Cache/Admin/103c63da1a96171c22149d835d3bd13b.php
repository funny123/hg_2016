<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=">
<title>变更登记</title>
<link rel="stylesheet" href="/hg_2016/Public/Admin/css/css.css">
<script src="/hg_2016/Public/Admin/js/jquery-1.9.1.js"></script>
<script src="/hg_2016/Public/Common/Layer/layer.js"></script>
    <script src="/hg_2016/Public/Common/My97Date/WdatePicker.js"></script>

    <script>
        //弹出搜索框

                $(document).ready(function(){
                    $("#group").dblclick(function(){
                        layer.tips('123','#realname');
                    });
                });



    </script>
    <script type="text/javascript">
        $(document).ready(function() {

                $(".menu1 span").hover(
                        function() {
                            $(this).children("div").attr("style", "display: block");
                        },
                        function() {
                            $(this).children("div").attr("style", "");
                        })

        });
    </script>
    <script>
        //导出excel用户
        function djout_excel(){
            var str = [];
            $("input[name='user_id[]']:checkbox").each(function () {
                if($(this).prop("checked")){
                    str.push($(this).val());
                }
            });
            var len = str.length;
            if (len == 0) {
                parent.layer.open({
                    type: 2,
                    shadeClose: true,
                    shade: 0.5,
                    area: ['450px', '500'],
                    title: '【金裕道】导出用户',
                    content: "<?php echo U('NewMember/djout_excel',['type'=>$type]);?>"
                });
            }else{
                var url='/hg_2016/Admin/NewMember/djout_excel'
                window.location.href=url+'/user_id/'+str+'/type/'+"<?php echo ($type); ?>";
            }

        }

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
    	<h4><img class="nav_img" src="/hg_2016/Public/Admin/img/tab.gif" /><span class="nav_a">变更登记</span></h4>

    </div>
    <div class="nav_title">

    </div>
    <?php if( $_SESSION['aid'] == 1): ?><div class="nav_button">
            <a href="javascript:;" onclick="djout_excel();"><button class="button">+ 导出用户</button></a>
        </div><?php endif; ?>

</div>


<div class="list">
    <form name="searchform" method="get" action="">
        <select name="member">
            <option value="">选择条件</option>
            <option value="loginname" <?php if(I('member') == 'loginname'): ?>selected="selected"<?php endif; ?>>交易账户</option>
            <option value="codeid" <?php if(I('member') == 'codeid'): ?>selected="selected"<?php endif; ?>>身份证号</option>
            <option value="agentname" <?php if(I('member') == 'agentname'): ?>selected="selected"<?php endif; ?>>原经纪人</option>
            <option value="agentname_x" <?php if(I('member') == 'agentname_x'): ?>selected="selected"<?php endif; ?>>现经纪人</option>
            <option value="department" <?php if(I('member') == 'department'): ?>selected="selected"<?php endif; ?>>部门</option>
        </select>
        <input type="text" name="textsearcherkeywords" value="<?php echo I('textsearcherkeywords');?>" />
        &nbsp;更改时间：<input type="text" name="startime" value="<?php echo I('startime');?>"  class="Wdate"  onFocus="WdatePicker({lang:'zh-cn',dateFmt:'yyyy-MM-dd'})" readonly />&nbsp;至&nbsp;<input type="text" name="endtime"  value="<?php echo I('endtime');?>" class="Wdate"  onFocus="WdatePicker({lang:'zh-cn',dateFmt:'yyyy-MM-dd'})" readonly />&nbsp;
        <input type="submit" value="查询" />&nbsp;
    </form>
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_table">
          <form action="/hg_2016/Admin/NewMember/edit_mul" method="post" id="form2">
      <thead>
	    <tr class="action">
            <td width="1%"><div align="center"><input  name="chkall" type="checkbox" id="chkall" onclick="selectall(this.form)"></div></td>
	      <td width="2%" id="add1"><div align="center">ID</div></td>
            <td width="6%"><div align="center">更改时间</div></td>
	      <td width="3%"><div align="center">交易账户</div></td>
            <td width="3%"><div align="center">模拟账号</div></td>
	      <td width=6%"><div align="center" id="realname">客户姓名</div></td>
            <td width=6%"><div align="center">身份证号</div></td>
	      <!--<td width="6%"><div align="center" id="time" onclick="time();">开户时间</div></td>-->
	      <!--<td width="5%"><div align="center">性别</div></td>-->

            <td width="6%"><div align="center">原经纪人</div></td>
                <td width="6%"><div align="center" style="background-color: red;color: white">现经纪人</div></td>
            <td width="5%"><div align="center" id="group" style="background-color: red;color: white">小组</div></td>
            <td width="5%"><div align="center" id="depart" style="background-color: red;color: white">部门</div></td>
            <td width="5%"><div align="center" id="remark">备注</div></td>


        </tr>
        </thead>
        <tbody>
        <?php if(is_array($lists)): foreach($lists as $key=>$vo): ?><tr id="del<?php echo ($vo["id"]); ?>" class="list" align="center">

                <td>
                    <div align="center"><input type="checkbox" name="user_id[]" value="<?php echo ($vo["id"]); ?>"></div>
                </td>
                <td height="40" id="add">
                    <div align="center" id="id"><?php echo ($vo["id"]); ?></div>
                </td>
                <td>
                    <div align="center"><?php echo (date("Y-m-d",$vo["time_x"])); ?></div>
                </td>
                <td>
                    <div align="center"><?php echo ($vo["loginname"]); ?></div>
                </td>
                <td>
                    <div align="center"><?php echo ($vo["moniname"]); ?></div>
                </td>
                <!--<td><div align="center"></div></td>-->
                <td>
                    <div align="center"><?php echo ($vo["realname"]); ?></div>
                </td>

                <td>
                    <div align="center"><?php echo ($vo["codeid"]); ?></div>
                </td>
                <!--<td>-->
                    <!--<div align="center"><?php echo (date("Y-m-d H:i:m",$vo["time"])); ?></div>-->
                <!--</td>-->
                <!--<td>-->
                    <!--<div align="center"><?php echo ($vo["sex"]); ?></div>-->
                <!--</td>-->


                <td>
                    <div align="center"><?php echo ($vo["agentname"]); ?></div>
                </td>
                <td>
                    <div align="center"><?php echo ($vo["agentname_x"]); ?></div>
                </td>
                <td>

                        <?php if($vo['groupname_x']!=$vo['groupname']){ echo ' <div align="center" style="color: #0000FF;">'.$vo['groupname_x']; }else{ echo ' <div align="center">'.$vo['groupname']; } ?>
                    </div>
                </td>
                <td>
                        <?php if($vo['department_x']!=$vo['department']){ echo ' <div align="center" style="color:#0000FF;">'.$vo['department_x']; }else{ echo ' <div align="center">'.$vo['department']; } ?>
                    </div>
                </td>
                <td>
                    <div align="center"><?php echo ($vo["remark"]); ?></div>
                </td>

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