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
    <script type="text/javascript">
        $(document).ready(
                function () {
                    $("#tel1").change(function () {
                        var val=$("#tel1").val();
//                        alert(val);
                        if(val==1){
                            $("#dx").html('<?php echo ($data["realname"]); ?>客户：您好！您的账户已申请成功。登录账号:<?php echo ($data["loginname"]); ?> 交易密码：123456电话密码：123456资金密码：111111感谢您在金裕道贵金属开户！为确保账户安全，请收到短信后及时修改密码。请妥善保管您的账号和密码，谢谢。');
                        }else if(val==2){
                            $("#dx").html('<?php echo ($data["realname"]); ?>客户：您好！恭喜您交易账号<?php echo ($data["loginname"]); ?>激活成功.');
                        }else{
                            $("#dx").html('<?php echo ($data["realname"]); ?>客户：您好！您的XX密码重置已申请成功。登录账号:<?php echo ($data["loginname"]); ?>交易密码：111111电话密码：111111资金密码：111111 网开登录密码：Aa123456感谢您在金裕道贵金属开户！为确保账户安全，请收到短信后及时修改密码。请妥善保管您的账号和密码，谢谢。 ');
                        }
                    });
                })
    </script>
</head>
<body>
<div class="list">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="details">
        <tbody>
        <form action="<?php echo U('NewMember/dx');?>" method="post" name="message">
            <tr>
                <td><div align="left">手机号：</div></td>
                <td>
                    <select name="password">
                        <option><?php echo ($data["tel"]); ?></option>
                        <option><?php echo ($data["telextend"]); ?></option>
                    </select>
                </td>
            </tr>
          <tr>
              <td><div align="left">短信：</div></td>
              <td><div align="left">
              <select name="tel1" id="tel1">
              <option value="1"><a class="a_button" href="javascript:;" onClick="viewtel(<?php echo ($vo["id"]); ?>);">实盘开户短信</a></option>
              <option value="2"><a class="a_button" href="javascript:;" onClick="viewtel(<?php echo ($vo["id"]); ?>);">激活短信</a></option>
              <option value="3"><a class="a_button" href="javascript:;" onClick="viewtel(<?php echo ($vo["id"]); ?>);">密码重置短信</a></option>
              </select>
              </div>
              </td>
          </tr>
          <tr>
              <td colspan="2"><div align="center"><textarea name="dx" id="dx" cols="60" rows="10" value="1111"><?php echo ($data["realname"]); ?>客户：您好！您的账户已申请成功。登录账号:<?php echo ($data["loginname"]); ?> 交易密码：123456电话密码：123456资金密码：111111感谢您在金裕道贵金属开户！为确保账户安全，请收到短信后及时修改密码。请妥善保管您的账号和密码，谢谢。</textarea></div></td>
          </tr>
          <tr>
              <td colspan="2" align="center">
                  <input type="submit" class="button" id="button" style="min-width:160px;" value="发送" />
              </td>
          </tr>
        </form>
          </tbody>
 </table>
    </div>
</body>
</html>