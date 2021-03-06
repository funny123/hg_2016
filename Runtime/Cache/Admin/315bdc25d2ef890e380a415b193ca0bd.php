<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=">
    <title>统计</title>
    <link rel="stylesheet" href="/hg_2016/Public/Admin/css/css.css">
    <script src="/hg_2016/Public/Admin/js/jquery-1.9.1.js"></script>
    <script src="/hg_2016/Public/Common/Layer/layer.js"></script>
    <script src="/hg_2016/Public/Common/My97Date/WdatePicker.js"></script>
    <style>
        div.menu1 ul
        {
            list-style:none; /* 去掉ul前面的符号 */
            margin: 0px; /* 与外界元素的距离为0 */
            padding: 0px; /* 与内部元素的距离为0 */
            width: auto; /* 宽度根据元素内容调整 */
        }
        /* 所有class为menu的div中的ul中的li样式 */
        div.menu1 ul li
        {
            float:left; /* 向左漂移，将竖排变为横排 */
        }
        /* 所有class为menu的div中的ul中的a样式(包括尚未点击的和点击过的样式) */
        div.menu1 ul li a, div.menu ul li a:visited
        {
            background-color: #465c71; /* 背景色 */
            border: 1px #4e667d solid; /* 边框 */
            color: #dde4ec; /* 文字颜色 */
            display: block; /* 此元素将显示为块级元素，此元素前后会带有换行符 */
            line-height: 1.35em; /* 行高 */
            padding: 4px 20px; /* 内部填充的距离 */
            text-decoration: none; /* 不显示超链接下划线 */
            white-space: nowrap; /* 对于文本内的空白处，不会换行，文本会在在同一行上继续，直到遇到 <br> 标签为止。 */
        }
        /* 所有class为menu的div中的ul中的a样式(鼠标移动到元素中的样式) */
        div.menu1 ul li a:hover
        {
            background-color: #bfcbd6; /* 背景色 */
            color: #465c71; /* 文字颜色 */
            text-decoration: none; /* 不显示超链接下划线 */
        }
        /* 所有class为menu的div中的ul中的a样式(鼠标点击元素时的样式) */
        div.menu1 ul li a:active
        {
            background-color: #465c71; /* 背景色 */
            color: #cfdbe6; /* 文字颜色 */
            text-decoration: none; /* 不显示超链接下划线 */

    </style>
</head>
<body>

<div class="nav">
    <div class="nav_title">
        <h4><img class="nav_img" src="/hg_2016/Public/Admin/img/tab.gif" /><span class="nav_a">综合数据统计</span></h4>
    </div>
</div>
<div class="form">
    <form name="form1" method="POST" action="">
        &nbsp;开户形式:&nbsp;
        <select name="sx" id="sx">
            <option value="1">现开</option>
            <option value="2">实盘网开</option>
            <option value="3">实盘网开，模拟现开</option>
            <option value="4">模拟现开，实盘未开</option>
        </select>
        <input type="submit" class="btn btn-danger btn-sm" value="统计">&nbsp;&nbsp;&nbsp;
    </form>
</div>
<div class="menu1">
    <ul >
        <li><a href="javascript:void(0);">经理部门</a></li>
        <li><a href="javascript:void(0);">各小组</a></li>
        <li><a href="javascript:void(0);">协议个数</a></li>
        <li><a href="javascript:void(0);">现开实盘个数</a></li>
        <li><a href="javascript:void(0);">现开模拟个数</a></li>
        <li><a href="javascript:void(0);">预计保护客户个数</a></li>
        <li><a href="javascript:void(0);">实际保护客户个数</a></li>
        <li><a href="javascript:void(0);">预计实盘个数</a></li>
        <li><a href="javascript:void(0);">实际实盘个数</a></li>
        <li><a href="javascript:void(0);">网开模拟个数</a></li>
        <li><a href="javascript:void(0);">激活个数</a></li>
        <li><a href="javascript:void(0);">二次激活个数</a></li>
        <li><a href="javascript:void(0);">销户</a></li>
    </ul>
</div><br><br>
<div style="float:left;margin-left:20px ">
    <ul>
        <?php if(is_array($date)): foreach($date as $key=>$vo): ?><li>第<?php echo ($vo["department_x"]); ?>部门</li><hr><?php endforeach; endif; ?>
    </ul>
</div>
<div  style="float:left; margin-left:40px;">
    <ul>
        <?php if(is_array($date)): foreach($date as $key=>$vo): ?><li><?php echo ($vo["groupname_x"]); ?></li><hr><?php endforeach; endif; ?>
    </ul>
</div>

<div style="float:left; margin-left:70px;">
    <ul>
        <?php if(is_array($data)): foreach($data as $key=>$vo): ?><li><?php echo ($vo["xz_xy"]); ?></li><hr><?php endforeach; endif; ?>
    </ul>
</div>
<div style="float:left; margin-left:80px;">
    <ul>
        <?php if(is_array($data)): foreach($data as $key=>$vo): ?><li><?php echo ($vo["xz_xksp"]); ?></li><hr><?php endforeach; endif; ?>
    </ul>
</div>
<div style="float:left; margin-left:120px;">
    <ul>
        <?php if(is_array($data)): foreach($data as $key=>$vo): ?><li><?php echo ($vo["xz_xkmn"]); ?></li><hr><?php endforeach; endif; ?>
    </ul>
</div>
<div style="float:left; margin-left:150px;">
    <ul>
        <?php if(is_array($data)): foreach($data as $key=>$vo): ?><li><?php echo ($vo["xz_yjbh"]); ?></li><hr><?php endforeach; endif; ?>
    </ul>
</div>
<div style="float:left; margin-left:150px;">
    <ul>
        <?php if(is_array($data)): foreach($data as $key=>$vo): ?><li><?php echo ($vo["xz_sjbh"]); ?></li><hr><?php endforeach; endif; ?>
    </ul>
</div>
<div style="float:left; margin-left:120px;">
    <ul>
        <?php if(is_array($data)): foreach($data as $key=>$vo): ?><li><?php echo ($vo["xz_yjsp"]); ?></li><hr><?php endforeach; endif; ?>
    </ul>
</div>
<div style="float:left; margin-left:120px;">
    <ul>
        <?php if(is_array($data)): foreach($data as $key=>$vo): ?><li><?php echo ($vo["xz_sjsp"]); ?></li><hr><?php endforeach; endif; ?>
    </ul>
</div>
<div style="float:left; margin-left:120px;">
    <ul>
        <?php if(is_array($data)): foreach($data as $key=>$vo): ?><li><?php echo ($vo["xz_wkmn"]); ?></li><hr><?php endforeach; endif; ?>
    </ul>
</div>
<div style="float:left; margin-left:110px;">
    <ul>
        <?php if(is_array($data)): foreach($data as $key=>$vo): ?><li><?php echo ($vo["xz_jhgs"]); ?></li><hr><?php endforeach; endif; ?>
    </ul>
</div>
<div style="float:left; margin-left:100px;">
    <ul>
        <?php if(is_array($data)): foreach($data as $key=>$vo): ?><li><?php echo ($vo["xz_ecjh"]); ?></li><hr><?php endforeach; endif; ?>
    </ul>
</div>
<div style="float:left; margin-left:90px;">
    <ul>
        <?php if(is_array($data)): foreach($data as $key=>$vo): ?><li><?php echo ($vo["xz_yx"]); ?></li><hr><?php endforeach; endif; ?>
    </ul>
</div>
</body>
</html>