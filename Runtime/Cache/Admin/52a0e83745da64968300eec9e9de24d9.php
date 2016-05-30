<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=">
<title>客户管理</title>
<link rel="stylesheet" href="/hg_2016/Public/Admin/css/css.css">
<script src="/hg_2016/Public/Admin/js/jquery-1.9.1.js"></script>
<script src="/hg_2016/Public/Common/Layer/layer.js"></script>
    <script src="/hg_2016/Public/Common/My97Date/WdatePicker.js"></script>
<script>
    //控制左边菜单显示或隐藏
    function change_sub_menu(id){
        $('.sub_menu li a').removeClass();
        $('#sub_menu_'+id).attr('class','sub_menu_hover');
    }
//添加用户
function add(){
    parent.layer.open({
        type: 2,
        shadeClose: true,
        shade: 0.5,
        area: ['850px', '840px'],
        title: '添加用户',
        content: '<?php echo U("Member/member_add");?>'
    });
}
//导入excel用户
function add_excel(){
    parent.layer.open({
        type: 2,
        shadeClose: true,
        shade: 0.5,
        area: ['450px', '200px'],
        title: '【裕道】导入用户',
        content: '<?php echo U("Member/add_excel");?>'
    });
}
//导出excel用户
function out_excel(){
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
            title: '【裕道】导出用户',
            content: "<?php echo U('Member/out_excel',['type'=>$type]);?>"
        });
    }else{
        var url='/hg_2016/Admin/Member/out_excel'
        window.location.href=url+'/user_id/'+str+'/type/'+"<?php echo ($type); ?>";
    }

}
//编辑用户
function edit(id){
    parent.layer.open({
        type: 2,
        shadeClose: true,
        shade: 0.5,
        area: ['850px', '840px'],
        title: '编辑账号信息',
        content: '<?php echo U("Member/member_edit");?>?id='+id
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
        content: '<?php echo U("Member/edit_mul");?>?id='+id
    });
}
//批量编辑用户经纪人
function edit_mul2(){
    $(document).ready(function(){
        var userid=$('input[name="user_id[]"]:checked');//获取复选框的值
        if(userid.length==0){
            alert('请选择用户');
            return false;
        }
        //$("#button1").click(function(){
            $("#form2").submit();
      //  });
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
        content: '<?php echo U("Member/viewtel");?>?id='+id
    });
}
//时间筛选
function viewtel1(id){
    parent.layer.open({
        type: 2,
        shadeClose: true,
        shade: 0.5,
        area: ['550px', '540px'],
        title: '发送短信',
        content: '<?php echo U("Member/viewtel");?>?id='+id
    });
}
function selectall(whosform){
    for(var i=0;i<whosform.elements.length;i++){
        var box = whosform.elements[i];
        if (box.name != 'chkall')
            box.checked = whosform.chkall.checked;
    }
}
////删除用户
//function  del(id){
//    $("#del"+id+" td").css('background','#CBDFF2');
//    parent.layer.confirm('真的要销户吗？', {
//        btn: ['确认','取消'], //按钮
//        shade: 0.5 //显示遮罩
//    }, function(){
//        $.post("<?php echo U('Member/member_del');?>", { "id": id},function(data){
//            if(data == 1){
//                parent.layer.msg('销户成功', { icon: 1, time: 1000 }, function(){
//
//                    });
//
//            }else{
//                parent.layer.msg('销户失败', {icon: 2, time: 2000 });
//            }
//        }, "json");
//    },function(){
//        $("#del"+id+" td").css('border-top','0');
//        $("#del"+id+" td").css('border-bottom','1px solid #EFEFEF');
//    });
//}
</script>
    <script>
        //弹出搜索框

                $(document).ready(function(){
//                    $("#groupso").click(function(){
//                       // $("#group").html("<input type='text' name='group1' id='group1' size='10' placeholder='小组'/><input type='hidden' value='1' name='sx' id='sx1'/>");
//                        $('#groupInput').css('display','block');
//                        $('#groupcenter').css('display','none');
//                        $('#departInput').css('display','none');
//                        $('#departcenter').css('display','block');
//                        $('#agentInput').css('display','none');
//                        $('#agentcenter').css('display','block');
//                        $('#realnInput').css('display','none');
//                        $('#realncenter').css('display','block');
//                        $('#codeiInput').css('display','none');
//                        $('#codeicenter').css('display','block');
//                        $('#loginnInput').css('display','none');
//                        $('#loginncenter').css('display','block');
//                        $('#jihuotInput').css('display','none');
//                        $('#jihuotcenter').css('display','block');
//                        $('#timeInput').css('display','none');
//                        $('#timecenter').css('display','block');
//                        $('#group1').keydown(function(e){
//                            if(e.keyCode==13) {
//                                $("#keyword").val($("#group1").val());
//                                $("#sx").val($("#sx1").val());
//                                $("#group").html("小组");
//                                $("form.formSo").submit();
//                            }
//                        });
//                    });
//
//               $("#departso").click(function(){
//                        $('#departInput').css('display','block');
//                        $('#departcenter').css('display','none');
//                        $('#groupInput').css('display','none');
//                        $('#groupcenter').css('display','block');
//                        $('#agentInput').css('display','none');
//                        $('#agentcenter').css('display','block');
//                        $('#realnInput').css('display','none');
//                        $('#realncenter').css('display','block');
//                        $('#codeiInput').css('display','none');
//                        $('#codeicenter').css('display','block');
//                        $('#loginnInput').css('display','none');
//                        $('#loginncenter').css('display','block');
//                        $('#jihuotInput').css('display','none');
//                        $('#jihuotcenter').css('display','block');
//                        $('#timeInput').css('display','none');
//                        $('#timecenter').css('display','block');
//                        //$("#depart").html("");
//                        $('#depart1').keydown(function(e){
//                            if(e.keyCode==13) {
//                                $("#keyword").val($("#depart1").val());
//                                $("#sx").val($("#sx1").val());
//                                $("#depart").html("部门");
//                                $("form.formSo").submit();
//                            }
//                        });
//                    });
//                    //
//                    $("#agentso").click(function(){
//                        //$("#agent").html("<input type='text' name='agent1' id='agent1' size='10' placeholder='经纪人'/><input type='hidden' value='3' name='sx' id='sx1'/>");
//                        $('#agentInput').css('display','block');
//                        $('#agentcenter').css('display','none');
//
//                        $('#departInput').css('display','none');
//                        $('#departcenter').css('display','block');
//                        $('#groupInput').css('display','none');
//                        $('#groupcenter').css('display','block');
//                        $('#realnInput').css('display','none');
//                        $('#realncenter').css('display','block');
//                        $('#codeiInput').css('display','none');
//                        $('#codeicenter').css('display','block');
//                        $('#loginnInput').css('display','none');
//                        $('#loginncenter').css('display','block');
//                        $('#jihuotInput').css('display','none');
//                        $('#jihuotcenter').css('display','block');
//                        $('#timeInput').css('display','none');
//                        $('#timecenter').css('display','block');
//                        $('#agent1').keydown(function(e){
//                            if(e.keyCode==13) {
//                                $("#keyword").val($("#agent1").val());
//                                $("#sx").val($("#sx1").val());
//                                $("#agent").html("经纪人");
//                                $("form.formSo").submit();
//                            }
//                        });
//                    });
//
//
//                    $("#jihuoso").click(function(){
//                        //$("#jihuot").html("<input id='jihuoso' type='text' onClick='WdatePicker()'/><input type='hidden' value='4' name='sx' id='sx1'/>");
//                        $('#jihuotInput').css('display','block');
//                        $('#jihuotcenter').css('display','none');
//
//                        $('#departInput').css('display','none');
//                        $('#departcenter').css('display','block');
//                        $('#groupInput').css('display','none');
//                        $('#groupcenter').css('display','block');
//                        $('#agentInput').css('display','none');
//                        $('#agentcenter').css('display','block');
//                        $('#codeiInput').css('display','none');
//                        $('#codeicenter').css('display','block');
//                        $('#realnInput').css('display','none');
//                        $('#realncenter').css('display','block');
//                        $('#loginnInput').css('display','none');
//                        $('#loginncenter').css('display','block');
//                        $('#timeInput').css('display','none');
//                        $('#timecenter').css('display','block');
//                        $('#jihuoso').keydown(function(e){
//                            if(e.keyCode==13) {
//                                $("#keyword").val($("#jihuoso").val());
//                                $("#sx").val($("#sx1").val());
//                                $("#jihuot").html("激活时间");
//                                $("form.formSo").submit();
//                            }
//                        });
//                    });
//
//                    $("#realso").click(function(){
//                        //$("#realn").html("<input type='text' name='realn1' id='realn1' size='13' placeholder='姓名'/><input type='hidden' value='5' name='sx' id='sx1'/>");
//                        $('#realnInput').css('display','block');
//                        $('#realncenter').css('display','none');
//                        $('#departInput').css('display','none');
//                        $('#departcenter').css('display','block');
//                        $('#groupInput').css('display','none');
//                        $('#groupcenter').css('display','block');
//                        $('#agentInput').css('display','none');
//                        $('#agentcenter').css('display','block');
//                        $('#codeiInput').css('display','none');
//                        $('#codeicenter').css('display','block');
//                        $('#loginnInput').css('display','none');
//                        $('#loginncenter').css('display','block');
//                        $('#jihuotInput').css('display','none');
//                        $('#jihuotcenter').css('display','block');
//                        $('#timeInput').css('display','none');
//                        $('#timecenter').css('display','block');
//                        $('#realn1').keydown(function(e){
//                            if(e.keyCode==13) {
//                                $("#keyword").val($("#realn1").val());
//                                $("#sx").val($("#sx1").val());
//                                $("#realn").html("姓名");
//                                $("form.formSo").submit();
//                            }
//                        });
//                    });
//                    //
//                    $("#codeidso").click(function(){
//                        //$("#codei").html("<input type='text' name='codei1' id='codei1' size='18' placeholder='身份证'/><input type='hidden' value='6' name='sx' id='sx1'/>");
//                        $('#codeiInput').css('display','block');
//                        $('#codeicenter').css('display','none');
//                        $('#departInput').css('display','none');
//                        $('#departcenter').css('display','block');
//                        $('#groupInput').css('display','none');
//                        $('#groupcenter').css('display','block');
//                        $('#agentInput').css('display','none');
//                        $('#agentcenter').css('display','block');
//                        $('#realnInput').css('display','none');
//                        $('#realncenter').css('display','block');
//                        $('#loginnInput').css('display','none');
//                        $('#loginncenter').css('display','block');
//                        $('#jihuotInput').css('display','none');
//                        $('#jihuotcenter').css('display','block');
//                        $('#timeInput').css('display','none');
//                        $('#timecenter').css('display','block');
//                        $('#codei1').keydown(function(e){
//                            if(e.keyCode==13) {
//                                $("#keyword").val($("#codei1").val());
//                                $("#sx").val($("#sx1").val());
//                                $("#codei").html("身份证号");
//                                $("form.formSo").submit();
//                            }
//                        });
//                    });
//                    //
//                    $("#loginso").click(function(){
//                       // $("#loginn").html("<input type='text' name='loginn1' id='loginn1' size='15' placeholder='交易帐号'/><input type='hidden' value='7' name='sx' id='sx1'/>");
//                        $('#loginnInput').css('display','block');
//                        $('#loginncenter').css('display','none');
//
//                        $('#departInput').css('display','none');
//                        $('#departcenter').css('display','block');
//                        $('#groupInput').css('display','none');
//                        $('#groupcenter').css('display','block');
//                        $('#agentInput').css('display','none');
//                        $('#agentcenter').css('display','block');
//                        $('#codeiInput').css('display','none');
//                        $('#codeicenter').css('display','block');
//                        $('#realnInput').css('display','none');
//                        $('#realncenter').css('display','block');
//                        $('#jihuotInput').css('display','none');
//                        $('#jihuotcenter').css('display','block');
//                        $('#timeInput').css('display','none');
//                        $('#timecenter').css('display','block');
//                        $('#loginn1').keydown(function(e){
//                            if(e.keyCode==13) {
//                                $("#keyword").val($("#loginn1").val());
//                                $("#sx").val($("#sx1").val());
//                                $("#loginn").html("交易帐号");
//                                $("form.formSo").submit();
//                            }
//                        });
//                    });
//
//                    $("#timeso").click(function(){
//                        // $("#loginn").html("<input type='text' name='loginn1' id='loginn1' size='15' placeholder='交易帐号'/><input type='hidden' value='7' name='sx' id='sx1'/>");
//                        $('#timeInput').css('display','block');
//                        $('#timecenter').css('display','none');
//
//                        $('#departInput').css('display','none');
//                        $('#departcenter').css('display','block');
//                        $('#groupInput').css('display','none');
//                        $('#groupcenter').css('display','block');
//                        $('#agentInput').css('display','none');
//                        $('#agentcenter').css('display','block');
//                        $('#codeiInput').css('display','none');
//                        $('#codeicenter').css('display','block');
//                        $('#realnInput').css('display','none');
//                        $('#realncenter').css('display','block');
//                        $('#jihuotInput').css('display','none');
//                        $('#jihuotcenter').css('display','block');
//                        $('#loginnInput').css('display','none');
//                        $('#loginncenter').css('display','block');
//                        $('#time1').keydown(function(e){
//                            if(e.keyCode==13) {
//                                $("#keyword").val($("#time1").val());
//                                $("#sx").val($("#sx1").val());
//                                $("#time").html("交易帐号");
//                                $("form.formSo").submit();
//                            }
//                        });
//                    });


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
                    $("#agentnameup").click(function(){
                        $("#order").val('agentname desc');
                        $("form.formSo").submit();

                    });
                    $("#agentnamedown").click(function(){
                        $("#order").val('agentname asc');
                        $("form.formSo").submit();

                    });
                    //


                    //激活资金
                    $("#jihuomoneyup").click(function(){
                        $("#order").val('jihuomoney desc');
                        $("form.formSo").submit();

                    });
                    $("#jihuomoneydown").click(function(){
                        $("#order").val('jihuomoney asc');
                        $("form.formSo").submit();

                    });

                    $("#loginup").click(function(){
                        $("#order").val('loginname desc');
                        $("form.formSo").submit();

                    });
                    $("#logindown").click(function(){
                        $("#order").val('loginname asc');
                        $("form.formSo").submit();

                    });
                    //
                    $("#group").click(function(){
                       $("#shai_x").show();
                        });

                     //模拟帐号
                    $("#moninameup").click(function(){
                        $("#order").val('moniname desc');
                        $("form.formSo").submit();

                    });

                    $("#moninamedown").click(function(){
                        $("#order").val('moniname asc');
                        $("form.formSo").submit();

                    });
                    //登录时间
                    $("#timeup").click(function(){
                        $("#order").val('time desc');
                        $("form.formSo").submit();

                    });
                    $("#timedown").click(function(){
                        $("#order").val('time asc');
                        $("form.formSo").submit();

                    });
                    $("#jihuotimeup").click(function(){
                        $("#order").val('jihuotime desc');
                        $("form.formSo").submit();

                    });
                    $("#jihuotimedown").click(function(){
                        $("#order").val('jihuotime asc');
                        $("form.formSo").submit();

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
        <h4><img class="nav_img" src="/hg_2016/Public/Admin/img/tab.gif" /><span class="nav_a">客户列表</span></h4>

    </div>
    <!--客户列表箭头查询-->

    <div class="nav_title" id="shai_x">
    <form name="form1" class="formSo" method="get" action="<?php echo U('Member/member_list');?>">
        <input name="keyword" type="hidden" id="keyword" value="" class="s26" />
        <input name="sx" type="hidden" id="sx" value="" class="s26" />
        <input name="order" type="hidden" id="order" value="" class="s26" />
        <input type="submit" id="tj" class="btn btn-danger btn-sm" value="">&nbsp;
    </form>
    </div>
    <div class="nav_title" id="paixu">
        <form name="form3" class="formPx" method="get" action="<?php echo U('Member/member_list');?>">
            <input name="order" type="hidden" id="order" value="" class="s26" />


            <input type="submit" id="pxtj" class="btn btn-danger btn-sm" value="">&nbsp;
        </form>
    </div>

    <?php if( $_SESSION['aid'] == 1): ?><div class="nav_button">
        <a href="javascript:;" onclick="edit_mul2();"><button class="button" id="button1">+ 批量修改</button></a>
        <a href="javascript:;" onclick="add();"><button class="button">+ 添加用户</button></a>
        <a href="javascript:;" onclick="add_excel();"><button class="button">+ 导入用户</button></a>
        <a href="javascript:;" onclick="out_excel();"><button class="button">+ 导出用户</button></a>
    </div><?php endif; ?>
</div>


<div class="list">
      <table width="1800px" border="0" cellpadding="0" cellspacing="0" class="list_table">
          <form name="searchform" method="get" action="<?php echo U('Member/member_list');?>">
              <select name="member">
                  <option value="">选择条件</option>
                  <option value="loginname" <?php if(I('member') == 'loginname'): ?>selected="selected"<?php endif; ?>>交易账户</option>
                  <option value="realname" <?php if(I('member') == 'realname'): ?>selected="selected"<?php endif; ?>>真实姓名</option>
                  <option value="codeid" <?php if(I('member') == 'codeid'): ?>selected="selected"<?php endif; ?>>身份证号</option>
                  <option value="agentname_x" <?php if(I('member') == 'agentname_x'): ?>selected="selected"<?php endif; ?>>经纪人</option>
                  <option value="groupname_x" <?php if(I('member') == 'groupname_x'): ?>selected="selected"<?php endif; ?>>小组</option>
                  <option value="department_x" <?php if(I('member') == 'department_x'): ?>selected="selected"<?php endif; ?>>部门</option>
                  <option value="birthday" <?php if(I('member') == 'birthday'): ?>selected="selected"<?php endif; ?>>生日</option>
                  <option value="jihuomoney" <?php if(I('member') == 'jihuomoney'): ?>selected="selected"<?php endif; ?>>激活资金</option>
              </select>
              <input type="text" name="textsearcherkeywords" value="<?php echo I('textsearcherkeywords');?>" />
              &nbsp;
                  <select name="timeselect">
                  <option value="">选择条件</option>
                  <option value="time" <?php if(I('timeselect') == 'time'): ?>selected="selected"<?php endif; ?>>开户时间</option>
                  <option value="jihuotime" <?php if(I('timeselect') == 'jihuotime'): ?>selected="selected"<?php endif; ?>>激活时间</option>
                  </select>
              <input type="text" name="startime"  class="Wdate" value="<?php echo I('startime');?>"  onFocus="WdatePicker({lang:'zh-cn',dateFmt:'yy-MM-dd'})" readonly/>&nbsp;
              &nbsp;至&nbsp;<input type="text" name="endtime"  class="Wdate" value="<?php echo I('endtime');?>"  onFocus="WdatePicker({lang:'zh-cn',dateFmt:'yy-MM-dd'})"  readonly />&nbsp;
              <input name="sousuo" type="submit" value="搜索" class="imgbtn" />
          </form>
          <form action="/hg_2016/Admin/Member/edit_mul" method="post" id="form2">
      <thead>
        <tr class="action">
            <td width="1%"><div align="center"><input  name="chkall" type="checkbox" id="chkall" onclick="selectall(this.form)"></div></td>
          <td width="1%" id="add1"><div align="center">ID</div></td>
          <td width="4%"><div align="center" id="loginn">
              <div id="loginnInput" style="display: none;">
                  <input type='text' name='loginn1' id='loginn1' size='10' placeholder='交易账户'/><input type='hidden' value='2' name='sx' id='sx1'/>
              </div>
              <div id="loginncenter">交易账户
              <?php if(I('order') == 'loginname desc' ): ?><img id="logindown" align="center" src="/hg_2016/Public/admin/img/down.png">

                  <?php else: ?>
                  <img id="loginup" align="center" src="/hg_2016/Public/admin/img/up.png"><?php endif; ?>
              </div>
          </div>
          </td>
            <td width="4%"><div align="center" id="monin">模拟账号
                <?php if(I('order') == 'moniname desc' ): ?><img id="moninamedown" align="center" src="/hg_2016/Public/admin/img/down.png">

                    <?php else: ?>
                    <img id="moninameup" align="center" src="/hg_2016/Public/admin/img/up.png"><?php endif; ?>
            </div>
            </td>
          <td width="4%"><div align="center" id="realn">
              <div id="realnInput" style="display: none;">
                  <input type='text' name='realn1' id='realn1' size='10' placeholder='真实姓名'/><input type='hidden' value='2' name='sx' id='sx1'/>
              </div>
              <div id="realncenter">真实姓名</div></div></td>
            <td width="3%"><div align="center" id="codei">
                <div id="codeiInput" style="display: none;">
                    <input type='text' name='codei1' id='codei1' size='10' placeholder='身份证号'/><input type='hidden' value='2' name='sx' id='sx1'/>
                </div>
                <div id="codeicenter">身份证号</div></div></td>

          <td width="4%"><div align="center" id="time" onclick="time();">
              <div id="timeInput" style="display: none;">
                  <input type='text' name='time1' id='time1' size='10' placeholder='开户时间'/><input type='hidden' value='2' name='sx' id='sx1'/>
              </div>
              <div id="timecenter">开户时间
              <?php if(I('order') == 'time desc' ): ?><img id="timedown" align="center" src="/hg_2016/Public/admin/img/down.png">

                  <?php else: ?>
                  <img id="timeup" align="center" src="/hg_2016/Public/admin/img/up.png"><?php endif; ?>
              </div>
              </div>
          </td>

          <td width="1%"><div align="center">电话</div></td>
          <td width="2%"><div align="center" id="agent">
              <div id="agentInput" style="display: none;">
                  <input type='text' name='agent1' id='agent1' size='10' placeholder='经纪人'/><input type='hidden' value='2' name='sx' id='sx1'/>
              </div>
              <div id="agentcenter">经纪人
              <?php if(I('order') == 'agentname desc' ): ?><img id="agentnamedown" align="center" src="/hg_2016/Public/admin/img/down.png">

                  <?php else: ?>
                  <img id="agentnameup" align="center" src="/hg_2016/Public/admin/img/up.png"><?php endif; ?>
                  </div>
            </div>
          </td>
          <td width="3%"><div align="center" id="group">
              <div id="groupInput" style="display: none;">
                  <input type='text' name='group1' id='group1' size='10' placeholder='小组'/><input type='hidden' value='2' name='sx' id='sx1'/>
              </div>
              <div id="groupcenter">小组
              <?php if(I('order') == 'groupname desc' ): ?><img id="orderdown" align="center" src="/hg_2016/Public/admin/img/down.png">

                  <?php else: ?>
                  <img id="orderup" align="center" src="/hg_2016/Public/admin/img/up.png"><?php endif; ?>
                  </div>
            </div>
          </td>
            <td width="3%"><div align="center" id="depart">
                <div id="departInput" style="display: none;">
                    <input type='text' name='depart1' id='depart1' size='10' placeholder='部门'/><input type='hidden' value='2' name='sx' id='sx1'/>
                </div>
                <div id="departcenter">部门
                    <?php if(I('order') == 'department desc' ): ?><img id="departmentdown" align="center" src="/hg_2016/Public/admin/img/down.png">

                        <?php else: ?>
                        <img id="departmentup" align="center" src="/hg_2016/Public/admin/img/up.png"><?php endif; ?>
                </div>
                </div>
            </td>
            <td width="3%"><div align="center">生日</div></td>
            <td width="4%"><div align="center" id="jihuot">
                <div id="jihuotInput" style="display: none;">
                    <input type='text' name='jihuot' id='jihuot' size='10' placeholder='激活时间'/><input type='hidden' value='2' name='sx' id='sx1'/>
                </div>
                <div id="jihuotcenter">激活时间
                <?php if(I('order') == 'jihuotime desc' ): ?><img id="jihuotimedown" align="center" src="/hg_2016/Public/admin/img/down.png">

                    <?php else: ?>
                    <img id="jihuotimeup" align="center" src="/hg_2016/Public/admin/img/up.png"><?php endif; ?>
                </div>
                </div>
            </td>
            <td width="4%"><div align="center">激活资金
                <?php if(I('order') == 'jihuomoney desc' ): ?><img id="jihuomoneydown" align="center" src="/hg_2016/Public/admin/img/down.png">

                    <?php else: ?>
                    <img id="jihuomoneyup" align="center" src="/hg_2016/Public/admin/img/up.png"><?php endif; ?>
                </div>
            </td>
           <!--<td width="1%"><div align="center">操作</div></td>-->
        </tr>
        </thead>
        <tbody>

        <?php if(is_array($lists)): foreach($lists as $key=>$vo): if($vo["cong"] == 1 or $vo["cong1"] == 1): ?><tr id="del<?php echo ($vo["id"]); ?>" class="list" align="center" bgcolor="">
                <?php else: ?>
                <tr id="del<?php echo ($vo["id"]); ?>" class="list" align="center"><?php endif; ?>
                <?php if($vo['status']): ?><td>
                    <div align="center"><input type="checkbox" name="user_id[]" value="<?php echo ($vo["id"]); ?>"></div>
                </td>
                <td height="40" id="add">
                    <div align="center"id="id"><?php echo ($vo["id"]); ?></div>
                </td>
                <td>
                    <div align="center"><?php echo ($vo["loginname"]); ?></div>
                </td>
                <td><div align="center"><?php echo ($vo["moniname"]); ?></div></td>

                <?php if($vo["cong"] == 1): ?><td style="background-color: darkorange">
                    <div align="center" ><a class="a_button" href="javascript:;" onClick="edit(<?php echo ($vo["id"]); ?>);"><font color="black"><?php echo ($vo["realname"]); ?></font></a></div>
                </td>
                    <?php else: ?>
                    <td>
                    <div align="center"><a class="a_button" href="javascript:;" onClick="edit(<?php echo ($vo["id"]); ?>);"><?php echo ($vo["realname"]); ?></a></div>
                </td><?php endif; ?>


                <?php if($vo["cong1"] == 1): ?><td style="background-color:darkorange">
                    <div align="center" ><font color="black"><?php echo ($vo["codeid"]); ?></font></div>
                </td>
                    <?php else: ?>
                    <td>
                    <div align="center"><?php echo ($vo["codeid"]); ?></div>
                </td><?php endif; ?>

                <td>
                    <div align="center"><?php echo (date('Y-m-d',$vo["time"])); ?></div>
                </td>
                <td>
                    <div align="center" ><a class="a_button" href="javascript:;" onClick="viewtel(<?php echo ($vo["id"]); ?>);">
                        <?php if($type == 1): echo ($vo["tel"]); ?>
                            <?php else: ?>
                            <?php echo (tel_sub($vo["tel"])); endif; ?>
                        </a>
                    </div>
                </td>

                <td>
                    <div align="center">
                        <?php echo ($vo["agentname_x"]); ?>
                    </div>
                </td>
                    <td>
                        <div align="center">
                            <?php echo ($vo["groupname_x"]); ?>
                        </div>
                    </td>
                    <td>
                        <div align="center">
                            <?php echo ($vo["department_x"]); ?>
                        </div>
                    </td>
                    <td>
                        <div align="center"><?php echo ($vo["birthday"]); ?></div>
                    </td>
                <td>
                    <div align="center">
                        <?php echo $vo['jihuotime']? date('Y-m-d',$vo['jihuotime']):''; ?>
                       </div>
                </td>
                <td>
                    <div align="center"><?php echo ($vo["jihuomoney"]); ?></div>
                </td>


                    <!-- <td>
                         <!-- <div align="center">
                              <!--<a class="a_button" href="javascript:;" onClick="edit(<?php echo ($vo["id"]); ?>);">编辑</a>
                             <a class="a_button" href="javascript:;" onclick="del(<?php echo ($vo[id]); ?>)">销</a>
                         </div>
                </td>-->
                    <?php else: ?>
                    <td>
                        <div align="center"><input type="checkbox" name="user_id[]" value="<?php echo ($vo["id"]); ?>"></div>
                    </td>
                    <td height="40" id="add">
                        <s><div align="center" id="id"><?php echo ($vo["id"]); ?></div></s>
                    </td>
                    <td>
                        <s><div align="center" ><?php echo ($vo["loginname"]); ?></div></s>
                    </td>
                    <td><div align="center"><?php echo ($vo["moniname"]); ?></div></td>
                    <td>
                        <s><div align="center"><a class="a_button" href="javascript:;" onClick="edit(<?php echo ($vo["id"]); ?>);"><?php echo ($vo["realname"]); ?></a></div></s>
                    </td>
                    <td>
                        <s><div align="center"><?php echo ($vo["codeid"]); ?></div></s>
                    </td>
                    <td>
                        <s><div align="center"><?php echo (date('Y-m-d',$vo["time"])); ?></div></s>
                    </td>

                    <td>
                        <div align="center" ><a class="a_button"  href="javascript:;" onClick="viewtel(<?php echo ($vo["id"]); ?>);">
                            <?php if($type == 1): echo ($vo["tel"]); ?>
                                <?php else: ?>
                                <?php echo (tel_sub($vo["tel"])); endif; ?>
                        </a>
                        </div>
                    </td>

                    <td>
                        <div align="center">
                            <?php echo ($vo["agentname_x"]); ?>
                        </div>
                    </td>
                    <td>
                        <div align="center">
                            <?php echo ($vo["groupname_x"]); ?>
                        </div>
                    </td>
                    <td>
                        <div align="center">
                            <?php echo ($vo["department_x"]); ?>
                        </div>
                    </td>
                    <td>
                        <div align="center"><?php echo ($vo["birthday"]); ?></div>
                    </td>
                    <td>
                        <div align="center">
                            <?php echo $vo['jihuotime']? date('Y-m-d',$vo['jihuotime']):''; ?>
                           </div>
                    </td>
                    <td>
                        <div align="center"><?php echo ($vo["jihuomoney"]); ?></div>
                    </td>


                    <!-- <td>
                         <div align="center">
                             <a class="a_button" href="javascript:;">已销户</a>
                         </div>
                    </td>--><?php endif; ?>
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