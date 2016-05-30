<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=">
    <title>后台管理系统</title>
    <link rel="stylesheet" href="/hg_2016/Public/Admin/css/css.css">
    <script src="/hg_2016/Public/Admin/js/jquery-1.9.1.js"></script>
    <script src="/hg_2016/Public/Common/Layer/layer.js"></script>
    <script src="/hg_2016/Public/Common/My97Date/WdatePicker.js"></script>
    <script>
        //批量编辑用户经纪人
        function edit_mul(id){
            parent.layer.open({
                type: 2,
                shadeClose: true,
                shade: 0.5,
                area: ['850px', '840px'],
                title: '批量编辑账号信息',
                content: '<?php echo U("Member/edit_mul");?>?id='+id
            });
        }
        function selectall(whosform){
            for(var i=0;i<whosform.elements.length;i++){
                var box = whosform.elements[i];
                if (box.name != 'chkall')
                    box.checked = whosform.chkall.checked;
            }
        }
        //批量编辑用户经纪人 小组、部门、激活日期
        function edit_mul_do(id){
            parent.layer.open({
                type: 2,
                shadeClose: true,
                shade: 0.5,
                area: ['850px', '840px'],
                title: '批量编辑账号信息',
                content: '<?php echo U("Member/edit_mul_do");?>?id='+id
            });
        }
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
    <script type="text/javascript">
        $(document).ready(function(){
            $("#btn1").click(function(){
                $("input[name='items']").attr("checked",true);
            });
            $("#btn2").click(function(){
                $("input[name='items']").attr("checked",false);
            })
        });
        $("#btn3").click(function(){
            $("input[name='items']").each(function(){
                $(this).attr("checked", !$(this).attr("checked"));
            });
        });

    </script>
    <script>
        function  edit_mul(user_id){

            parent.layer.confirm('真的要修改吗？', {
                btn: ['确认', '取消'], //按钮
                shade: 0.5 //显示遮罩
            }, function(){
                $("#button3").submit();

            });
        }
    </script>
    <script>
        function show_confirm()
        {
            var r=confirm("真的要修改吗？");
            if (r==true)
            {
                $("#button2").submit();
            }
        }
    </script>

    <script>
        $(document).ready(function() {

            $("#agentname_xg1").change(function(){
                $("#agentname_xg").val($("#agentname_xg1").val());

                $("#groupname_xg1").change(function(){
                    $("#groupname_xg").val($("#groupname_xg1").val());

                    $("#department_xg1").change(function(){
                        $("#department_xg").val($("#department_xg1").val());

                    });


                });
            });
        });
    </script>
</head>

<body>


<div class="nav">
    <div class="nav_title">
    </div>
    <?php if( $_SESSION['aid'] == 1): ?><div class="nav_button">
            <a href="javascript:;"><button class="button" id="button1">+ 批量修改</button></a>
        </div><?php endif; ?>
</div>

<form method="post" id="button2" action="/hg_2016/Admin/Member/edit_mul_do">
    <div class="list">

        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_table">
            <thead>
            <tr class="action">

                <td width="2%" id="ad"><div align="center">ID</div></td>
                <td width=6%"><div align="center">真实姓名</div></td>
                <td width="6%"><div align="center">经纪人</div></td>

                <td width="5%"><div align="center">小组</div></td>

                <td width="5%"><div align="center">部门</div></td>

            </tr>
            </thead>
            <tbody>
            <?php if(is_array($data)): foreach($data as $key=>$vo): ?><tr id="del<?php echo ($vo["id"]); ?>" class="list">
                    <input type="hidden" name="user_id[]" value="<?php echo ($vo["id"]); ?>"/>
                    <td height="50" id="add"><div align="center" id="id"><?php echo ($vo["id"]); ?></div></td>
                    <?php if($vo["moniname"] != '' ): ?><td><div align="center"><?php echo ($vo["realname"]); ?>[模拟]</div></td>
                        <?php else: ?>
                        <td><div align="center"><?php echo ($vo["realname"]); ?></div></td><?php endif; ?>
                    <td><div align="center"><?php echo ($vo["agentname"]); ?></div></td>

                    <td><div align="center"><?php echo ($vo["groupname"]); ?></div></td>

                    <td><div align="center"><?php echo ($vo["department"]); ?></div></td>
        </tr><?php endforeach; endif; ?>
        <td><div align="center">经纪人：<input type="text" name="agentname_x" id="agentname_xg1" placeholder="经纪人"/></div></td>
        <td><div align="center">小组：<input type="text" name="groupname_x" id="groupname_xg1" placeholder="小组"/></div></td>
        <td><div align="center">部门：<input type="text" name="department_x" id="department_xg1" placeholder="部门"/></div></td>
        <td>
            <div align="center">更改时间：<input type="text" name="time_x" id="time_x"  value="" class="Wdate" onFocus="WdatePicker({lang:'zh-cn',dateFmt:'yyyy/MM/dd'})"/>
            </div></td>
        <td><div align="center"><a class="button"  onclick="show_confirm();">确认</a></div></td>
        </tbody>
  </table>
    </div>
</form>
<!-- 分页 -->
<div class="page">
    <?php echo ($page); ?>
</div>


</body>
</html>