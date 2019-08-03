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
$charge_give_array=charge_give_allsums($id);   //充值，赠送的数组信息
$bcode = $s['bcode'];
$get_recommender_info_array = get_recommender_info($bcode); //推荐人的数组信息
$charge_sums_array = charge_sums($id,date("Y-m-d"));        //今日充值和赠送的数组信息
?>
<form name="form" id="form" method="post" action="member_save.php" onsubmit="return cfm_search();">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr>
		<td height="40" align="right" width="25%">会员账号：</td>
		<td colspan="11"><input readonly type="text" value="<?php echo $s['telephone']; ?>" name="telephone" id="telephone" class="input"/></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">会员昵称：</td>
		<td colspan="11"><input readonly type="text" value="<?php echo $s['nickname']; ?>" name="nickname" id="nickname" class="input"/></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">注册时间：</td>
		<td colspan="11"><input readonly type="text" value="<?php echo $s['regtime']; ?>" name="nickname" id="nickname" class="input"/></td>
    </tr>
    <tr>
		<td style="border-bottom: 1px dashed #529ee0;" height="40" align="right" width="25%">推荐码：</td>
		<td  style="border-bottom: 1px dashed #529ee0;" colspan="11"><input readonly type="text" value="<?php echo $s['ucode']; ?>" name="ucode" id="ucode" class="input"/></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">账户余额：</td>
		<td colspan="11" ><input style="font-weight:bold;" readonly type="text" value="<?php echo sprintf("%.2f",$s['money']); ?>" name="money" id="money" class="input"/>&nbsp;截止到<?php echo date("Y-m-d H:i:s"); ?></input></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">充值总额：</td>
		<td colspan="11" ><input style="font-weight:bold;" readonly type="text" value="<?php echo sprintf("%.2f",$charge_give_array['money']); ?>" name="chargesums" id="chargesums" class="input"/>&nbsp;截止到<?php echo date("Y-m-d H:i:s"); ?></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">赠送总额：</td>
		<td colspan="11" ><input style="font-weight:bold;" readonly type="text" value="<?php echo sprintf("%.2f",$charge_give_array['give']); ?>" name="givesums" id="givesums" class="input"/>&nbsp;截止到<?php echo date("Y-m-d H:i:s"); ?></td>
    </tr>
    <tr>
		<td height="40" style="border-bottom: 1px dashed #529ee0;"  align="right" width="25%">提现总额：</td>
		<td colspan="11" style="border-bottom: 1px dashed #529ee0;margin-bottom:5px;" ><input style="font-weight:bold;" readonly type="text" value="<?php echo sprintf("%.2f",pickup_sums_money($id)); ?>" name="givesums" id="givesums" class="input"/>&nbsp;截止到<?php echo date("Y-m-d H:i:s"); ?></td>
    </tr>
    <?php if($bcode!=""){ ?>
      <tr>
  		<td   height="40" align="right" width="25%">推荐人昵称：</td>
  		<td  colspan="11"><input readonly type="text" value="<?php echo $get_recommender_info_array['nickname']; ?>" name="ucode" id="ucode" class="input"/></td>
      </tr>
    <tr>
		<td height="40" align="right" width="25%">推荐人账号：</td>
		<td colspan="11"><input readonly type="text" value="<?php echo $get_recommender_info_array['telephone']; ?>" name="ucode" id="ucode" class="input"/></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">推荐人账户余额：</td>
		<td colspan="11"><input readonly type="text" value="<?php echo sprintf("%.2f",$get_recommender_info_array['money']); ?>" name="ucode" id="ucode" class="input"/></td>
    </tr>
    <tr>
		<td style="border-bottom: 1px dashed #529ee0;"  height="40" align="right" width="25%">推荐人推荐码：</td>
		<td  style="border-bottom: 1px dashed #529ee0;"  colspan="11"><input readonly type="text" value="<?php echo $get_recommender_info_array['ucode']; ?>" name="ucode" id="ucode" class="input"/></td>
    </tr>

  <?php } ?>

    <tr>
		<td height="40" align="right" width="25%">统计日期：</td>
		<td colspan="11"><input readonly type="text" value="<?php echo date("Y-m-d"); ?>" name="ymd" id="ymd" class="input"/></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">今日充值金额：</td>
		<td colspan="11"><input readonly type="text" value="<?php echo sprintf("%.2f",$charge_sums_array['money']); ?>" name="nickname" id="nickname" class="input"/></td>
    </tr>
    <tr>
		<td height="40" align="right" width="25%">今日赠送金额：</td>
		<td colspan="11"><input readonly type="text" value="<?php echo sprintf("%.2f",$charge_sums_array['give']); ?>" name="nickname" id="nickname" class="input"/></td>
    </tr>
    <tr>
    <td height="40" align="right" width="25%">今日提现金额：</td>
    <td colspan="11"><input readonly type="text" value="<?php echo sprintf("%.2f",pickup_money($id,date("Y-m-d"))); ?>" name="nickname" id="nickname" class="input"/></td>
    </tr>
    <tr>
    <td height="40" align="right" width="25%">今日下注总金额：</td>
    <td colspan="11"><input readonly type="text" value="<?php echo sprintf("%.2f",get_today_xiazhusum($id,date("Y-m-d"))); ?>" name="nickname" id="nickname" class="input"/></td>
    </tr>
    <tr>
    <td height="40" align="right" width="25%">今日中奖总金额：</td>
    <td colspan="11"><input readonly type="text" value="<?php echo sprintf("%.2f",get_today_zhongjiangsum($id,date("Y-m-d"))); ?>" name="nickname" id="nickname" class="input"/></td>
    </tr>
    <tr>
    <td height="40" align="right" width="25%">今日盈亏金额：</td>
    <td colspan="11"><input style="color:#509ee1; font-weight:bold;" readonly type="text" value="<?php echo sprintf("%.2f",get_today_yingkui($id,date("Y-m-d"))); ?>" name="nickname" id="nickname" class="input"/></td>
    </tr>
    <tr>
    <td height="40" align="right" width="25%">今日下注次数：</td>
    <td colspan="11"><input readonly type="text" value="<?php echo get_today_cishu($id,date("Y-m-d")); ?>" name="nickname" id="nickname" class="input"/></td>
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
