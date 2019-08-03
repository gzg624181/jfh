<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查询会员详情</title>
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
</head>
<body>
  <?php
if($type=="add"){
  $typename = "快速上分";
}elseif($type=="reduce"){
  $typename = "快速减分";
}elseif($type=="search"){
  $typename = "查询玩家信息";
}
   ?>
<div class="formHeader"><?php echo $typename; ?><a href="javascript:location.reload();" class="reload">刷新</a> </div>
<?php
$s=$dosql->GetOne("SELECT * from `#@__members` where id=$id");
$qrcode=$s['qrcode'];
?>
<form name="form" id="form" method="post" action="member_save.php" onsubmit="return cfm_search();">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr>
		<td height="40" align="right" width="25%">会员账号：</td>
		<td colspan="11"><?php echo $s['telephone']; ?></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">会员昵称：</td>
		<td colspan="11"><?php echo $s['nickname']; ?></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">推荐码：</td>
		<td colspan="11"><?php echo $s['ucode']; ?></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">账户余额：</td>
		<td colspan="11"><?php echo $s['money']; ?></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">统计日期：</td>
		<td colspan="11"><?php echo date("Y-m-d"); ?></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">今日充值金额：</td>
		<td colspan="11"><?php echo charge_sums($id,date("Y-m-d")); ?></td>
    </tr>
    <tr>
    <td height="40" align="right" width="25%">今日提现金额：</td>
    <td colspan="11"><?php  ?></td>
    </tr>
    <tr>
    <td height="40" align="right" width="25%">今日下注总金额：</td>
    <td colspan="11"><?php  ?></td>
    </tr>
    <tr>
    <td height="40" align="right" width="25%">今日中奖总金额：</td>
    <td colspan="11"><?php ?></td>
    </tr>
    <tr>
    <td height="40" align="right" width="25%">今日盈亏金额：</td>
    <td colspan="11"><?php  ?></td>
    </tr>
    <tr>
    <td height="40" align="right" width="25%">今日下注次数：</td>
    <td colspan="11"><?php ?></td>
    </tr>
		<tr>
    <td height="50" align="right">&nbsp;</td>
    <td><div class="formSubBtn" style="float:left; margin-top:5px;">
    <input type="submit" class="submit" style="line-height: 31px;" value="查询" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
  </div></td>
    </tr>
	</table>

</form>
</body>
</html>
