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
        //添加用户
        function add(){
            parent.layer.open({
                type: 2,
                shadeClose: true,
                shade: 0.5,
                area: ['850px', '840px'],
                title: '添加用户',
                content: '<?php echo U("NewMember/member_add");?>'
            });
        }
        //导入excel用户
        function add_excel(){
            parent.layer.open({
                type: 2,
                shadeClose: true,
                shade: 0.5,
                area: ['350px', '500'],
                title: '导入用户',
                content: '<?php echo U("NewMember/add_excel");?>'
            });
        }
        //导出excel用户
        function out_excel(){
            parent.layer.open({
                type: 2,
                shadeClose: true,
                shade: 0.5,
                area: ['350px', '500'],
                title: '导出用户',
                content: '<?php echo U("NewMember/out_excel");?>'
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
                content: '<?php echo U("NewMember/member_edit");?>?id='+id
            });
        }
        function subform(i) {

            var theform=document.form_do;
            theform.action=i;
            theform.submit();
        }
        //批量编辑用户经纪人
        function edit_mul(id){
            parent.layer.open({
                type: 2,
                shadeClose: true,
                shade: 0.5,
                area: ['850px', '840px'],
                title: '批量编辑账号信息',
                content: '<?php echo U("NewMember/edit_mul");?>?id='+id
            });
        }
        //查看客户手机号
        function viewtel(id){
            parent.layer.open({
                type: 2,
                shadeClose: true,
                shade: 0.5,
                area: ['550px', '540px'],
                title: '查看完整手机号',
                content: '<?php echo U("NewMember/viewtel");?>?id='+id
            });
        }
        //时间筛选
        function viewtel(id){
            parent.layer.open({
                type: 2,
                shadeClose: true,
                shade: 0.5,
                area: ['550px', '540px'],
                title: '查看完整手机号',
                content: '<?php echo U("NewMember/viewtel");?>?id='+id
            });
        }
        function selectall(whosform){
            for(var i=0;i<whosform.elements.length;i++){
                var box = whosform.elements[i];
                if (box.name != 'chkall')
                    box.checked = whosform.chkall.checked;
            }

        }
        //删除用户
        function del(id){
            $("#del"+id+" td").css('background','#CBDFF2');
            parent.layer.confirm('真的要销户吗？', {
                btn: ['确认','取消'], //按钮
                shade: 0.5 //显示遮罩
            }, function(){
                $.post("<?php echo U('NewMember/member_del');?>", { "id": id},function(data){
                    if(data == 1){
                        parent.layer.msg('销户成功', { icon: 1, time: 1000 }, function(){
                            $("#del"+id).remove();
                        });
                    }else{
                        parent.layer.msg('销户失败', {icon: 2, time: 2000 });
                    }
                }, "json");
            },function(){
                $("#del"+id+" td").css('border-top','0');
                $("#del"+id+" td").css('border-bottom','1px solid #EFEFEF');
            });
        }
    </script>
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
</head>
<body>


<div class="nav">
    <div class="nav_title">
        <h4><img class="nav_img" src="/hg_2016/Public/Admin/img/tab.gif" /><span class="nav_a">销户客户列表</span></h4>

    </div>
    <div class="nav_title">

    </div>

</div>


<div class="list">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_table">
        <form action="/hg_2016/Admin/NewMember/edit_mul_do" method="post">
            <thead>
            <tr class="action">
                <td width="1%"><div align="center"><input  name="chkall" type="checkbox" id="chkall" onclick="selectall(this.form)"></div></td>
                <td width="5%"><div align="center">销户时间</div></td>
                <td width="2%" id="add1"><div align="center">ID</div></td>
                <td width="3%"><div align="center">登录账号</div></td>

                <td width=6%"><div align="center" id="realname">真实姓名</div></td>
                <td width=6%"><div align="center">身份证号</div></td>
                <td width="6%"><div align="center" id="time" onclick="time();">登录时间</div></td>
                <td width="5%"><div align="center">电话</div></td>
                <td width="6%"><div align="center">经纪人</div></td>
                <td width="5%"><div align="center" id="group">小组</div></td>
                <td width="5%"><div align="center" id="depart">部门</div></td>
                <td width="6%"><div align="center">激活时间</div></td>
                <td width="6%"><div align="center">激活资金</div></td>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($lists)): foreach($lists as $key=>$vo): ?><tr id="del<?php echo ($vo["id"]); ?>" class="list">

                    <td><div align="center"><input type="checkbox" name="id[]" value="<<?php echo ($v["id"]); ?>>" ></div></td>
                    <td><div align="center"><del><?php echo (date("Y-m-d",$vo["xh_time"])); ?></del></div></td>
                    <td height="40" id="add"><div align="center" id="id"><del><?php echo ($vo["id"]); ?></del></div></td>
                    <td><div align="center"><del><?php echo ($vo["loginname"]); ?></del></div></td>
                    <!--<td><div align="center"><?php echo ($vo["moniname"]); ?></div></td>-->
                    <td><div align="center"><del><?php echo ($vo["realname"]); ?></del></div></td>
                    <td><div align="center"><del><?php echo ($vo["codeid"]); ?></del></div></td>
                    <td><div align="center"><del><?php echo (date('Y-m-d',$vo["time"])); ?></del></div></td>
                    <td><div align="center"><a class="a_button" href="javascript:;" ><del><?php echo (tel_sub($vo["tel"])); ?></del></a></div></td>

                    <td><div align="center"><del><?php echo ($vo["agentname_x"]); ?></del></div></td>
                    <td><div align="center"><del><?php echo ($vo["groupname_x"]); ?></del></div></td>
                    <td><div align="center"><del><?php echo ($vo["department_x"]); ?></del></div></td>
                    <td><div align="center"><del>
                        <?php echo $vo['jihuotime']? date('Y-m-d',$vo['jihuotime']):''; ?>
                    </del></div></td>
                    <td><div align="center"><del><?php echo ($vo["jihuomoney"]); ?></del></div></td>

                </tr><?php endforeach; endif; ?>
            </tbody>
        </form>
    </table>
</div>

<!-- 分页 -->
<div class="pages">
    <?php echo ($page); ?>
</div>


</body>
</html>