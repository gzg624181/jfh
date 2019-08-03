<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>单日账单统计</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/getuploadify.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
<script type="text/javascript" src="templates/js/getjcrop.js"></script>
<script type="text/javascript" src="templates/js/getinfosrc.js"></script>
<script type="text/javascript" src="plugin/colorpicker/colorpicker.js"></script>
<script type="text/javascript" src="plugin/calendar/calendar.js"></script>
<script type="text/javascript" src="editor/kindeditor-min.js"></script>
<script type="text/javascript" src="editor/lang/zh_CN.js"></script>
<script type="text/javascript" src="layer/layer.js"></script>
<script type="text/javascript" src="templates/js/getarea.js"></script>
<script type="text/javascript" src="layer/layer.js"></script>
<script>
function GetSearchs(){
var keyword= document.getElementById("keyword").value;
if($("#keyword").val() == "")
{
 alert("请输入回水操作日期！");
 $("#keyword").focus();
 return false;
}

window.location.href='zhangdan.php?keyword='+keyword;
}

</script>
</head>
<body>
  <?php
  //初始化参数

  $action  = isset($action)  ? $action  : '';
  $keyword = isset($keyword) ? $keyword : date("Y-m-d");
  ?>
<div class="formHeader">单日账单统计<a href="javascript:location.reload();" class="reload">刷新</a> </div>
<div class="toolbarTab">
	<div id="search" class="search"> <span class="s">
<input name="keyword" id="keyword" type="text" class="number" placeholder="请输入统计日期进行搜索" title="请输入统计日期进行搜索" />
		</span> <span class="b"><a href="javascript:;" onclick="GetSearchs();"></a></span></div>
	<div class="cl"></div>
</div>
<form name="form" id="form" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
    <tr>
    <td height="40" align="right" width="25%">统计日期：</td>
    <td colspan="11"><input readonly type="text" value="<?php echo $keyword; ?>" name="ymd" id="ymd" class="input"/></td>
    </tr>
		<tr>
		<td height="40" align="right" width="25%">注册所有会员数量：</td>
		<td colspan="11"><input readonly type="text" value="<?php echo get_allnumbers(); ?>" name="telephone" id="telephone" class="input"/></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">所有上分总数：</td>
		<td colspan="11"><input readonly type="text" value="<?php echo sprintf("%.2f",get_all_addmoney()); ?>" name="nickname" id="nickname" class="input"/></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">所有下分总数：</td>
		<td colspan="11"><input readonly type="text" value="<?php echo sprintf("%.2f",get_all_reducemoney()); ?>" name="nickname" id="nickname" class="input"/></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">所有下注总额：</td>
		<td colspan="11"><input readonly type="text" value="<?php echo sprintf("%.2f",get_all_xiazhumoney()); ?>" name="nickname" id="nickname" class="input"/></td>
    </tr>
    <tr>
    <td height="40" align="right" width="25%">所有赠送总额：</td>
    <td colspan="11"><input readonly type="text" value="<?php echo sprintf("%.2f",get_all_givemoney()); ?>" name="nickname" id="nickname" class="input"/></td>
    </tr>
    <tr>
    <td height="40" align="right" width="25%">所有中奖总额：</td>
    <td colspan="11"><input readonly type="text" value="<?php echo sprintf("%.2f",get_all_zjmoney()); ?>" name="nickname" id="nickname" class="input"/></td>
    </tr>
    <tr>
    <td height="40" align="right" width="25%">所有盈亏总额：</td>
    <td colspan="11"><input readonly type="text" value="<?php echo sprintf("%.2f",get_all_yingkuimoney()); ?>" name="nickname" id="nickname" class="input"/></td>
    </tr>
    <tr>
		<td style="border-bottom: 1px dashed #529ee0;" height="40" align="right" width="25%">会员剩余总分：</td>
		<td style="border-bottom: 1px dashed #529ee0;" colspan="11"><input style="font-weight:bold;color:#509ee1" readonly type="text" value="<?php echo sprintf("%.2f",get_lastmoney()); ?>" name="nickname" id="nickname" class="input"/></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">单日注册会员：</td>
		<td colspan="11"><input readonly type="text" value="<?php echo get_allnumbers($keyword); ?>" name="nickname" id="nickname" class="input"/></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">单日上分总额：</td>
		<td colspan="11" ><input style="font-weight:bold; color:red" readonly type="text" value="<?php echo sprintf("%.2f",get_all_addmoney($keyword)); ?>" name="money" id="money" class="input"/></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">单日下分总额：</td>
		<td colspan="11" ><input style="font-weight:bold;" readonly type="text" value="<?php echo sprintf("%.2f",get_all_reducemoney($keyword)); ?>" name="money" id="money" class="input"/></input></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">单日赠送总额：</td>
		<td colspan="11" ><input style="font-weight:bold;" readonly type="text" value="<?php echo sprintf("%.2f",get_all_givemoney($keyword)); ?>" name="money" id="money" class="input"/>&nbsp;截止到<?php echo date("Y-m-d H:i:s"); ?></input></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">单日下注总额：</td>
		<td colspan="11" ><input style="font-weight:bold;" readonly type="text" value="<?php echo sprintf("%.2f",get_all_xiazhumoney($keyword)); ?>" name="chargesums" id="chargesums" class="input"/>&nbsp;截止到<?php echo date("Y-m-d H:i:s"); ?></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">单日中奖总额：</td>
		<td colspan="11" ><input style="font-weight:bold;" readonly type="text" value="<?php echo sprintf("%.2f",get_all_zjmoney($keyword)); ?>" name="givesums" id="givesums" class="input"/></td>
    </tr>
    <tr>
    <td height="40" align="right" width="25%">单日盈亏总额：</td>
    <td colspan="11"><input readonly type="text" value="<?php echo sprintf("%.2f",get_all_yingkuimoney($keyword)); ?>" name="nickname" id="nickname" class="input"/></td>
    </tr>
    <tr>
    <td height="40" align="right" width="25%">单日下注次数：</td>
    <td colspan="11"><input readonly type="text" value="<?php echo get_all_cishu($ymd); ?>" name="nickname" id="nickname" class="input"/></td>
    </tr>
		<tr>
    <td height="50" align="right">&nbsp;</td>
    <td><div class="formSubBtn" style="float:left; margin-top:5px;">
		<input type="button" class="submit" value="返回" style="line-height: 31px;" onclick="history.go(-1);" />
  </div></td>
    </tr>
	</table>

</form>
</body>
</html>
