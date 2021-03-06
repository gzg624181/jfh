<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>充值收款账号</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<link href="templates/style/menu1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/listajax.js"></script>
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
<script type="text/javascript" src="layer/layer.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
</head>
<body>

	<div class="topToolbar">
    <?php
	$dosql->Execute("SELECT * FROM `pmw_shoukuan`");
    $num=$dosql->GetTotalRow();
	?>
    <span class="title">充值收款账号个数：</span><span class="num" style="color:red;"><?php echo $num;?></span>
 <a title="刷新" href="javascript:location.reload();" class="reload"><i class="fa fa-refresh" aria-hidden="true"></i></a></div>
<form name="form" id="form" method="post" action="shoukuan_save.php">
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="dataTable">
		<tr align="center" class="head">
		  <td width="12%" align="center">充值</td>
			<td width="15%" height="36" align="center">充值账户名</td>
			<td width="14%" align="left">充值账号</td>
			<td width="14%" align="center">充值方式</td>
			<td width="14%" align="center">银行名称</td>
			<td width="14%" align="center">支行名称</td>
			<td width="14%" align="center">添加时间</td>
		  <td width="3%" align="center">操作</td>
		</tr>
		<?php
		$jiuqian_la=0;
		$dopage->GetPage("SELECT * FROM `pmw_shoukuan`",10);
		while($row = $dosql->GetArray())
		{
		$numss[]=$row;
		switch($row['type'])
		{
			case 'alipay':
				$type = "支付宝充值";
				$images="templates/default/images/alipay.png";
				break;
			case 'bankpay':
				$type = "银行卡充值";
				$images="templates/default/images/cardpay.png";
				break;
			case 'wxpay':
				  $type = "微信充值";
				  $images="templates/default/images/weixinpay.png";
				  break;
			case 'qqpay':
						  $type = "qq财付通充值";
						  $images="templates/default/images/qqpay.jpg";
						  break;
			case 'yunshanfu':
								  $type = "云闪付充值";
								  $images="templates/default/images/yunshanfu.jpg";
								  break;
		}
		?>
		<tr align="left" class="dataTr">
		    <td align="center"><img src="../<?php echo $images;?>"  width="60" height="75" /></td>
			<td height="70" align="center"><?php echo $row['name']; ?></td>
			<td align="center"><?php echo $row['account']; ?></td>
			<td align="center"  class="num"><?php echo $type; ?></td>
			<td align="center"><?php echo $row['bankname']; ?></td>
			<td align="center"><?php echo $row['lastbankname']; ?></td>
			<td align="center"><span class="number"><?php echo date("Y-m-d H:i:s",$row['addtime']); ?></span></td>
			<td align="center">
            <div id="jsddm"><a title="删除" href="shoukuan_save.php?action=del3&id=<?php echo $row['id'];?>" onclick="return ConfDel(0);"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
            <div id="jsddm"><a title="编辑" href="shoukuan_update.php?id=<?php echo $row['id'];?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></div></td>
		</tr>
		<?php
		}
		?>
	</table>
</form>
<?php

//判断无记录样式
if($dosql->GetTotalRow() == 0)
{
	echo '<div class="dataEmpty">暂时没有相关的记录</div>';
}
?>
<div class="bottomToolbar"> <span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('shoukuan_save.php');" onclick="return ConfDelAll(0);">删除</a></span> <a href="shoukuan_add.php" class="dataBtn">新增收款账号</a> </div>
<div class="page"> <?php echo $dopage->GetList(); ?> </div>
<?php
//判断是否启用快捷工具栏
if($cfg_quicktool == 'Y')
{
?>
<div class="quickToolbar">
	<div class="qiuckWarp">
		<div class="quickArea">
        <a href="product_add.php" class="dataBtn">新增收款账号</a> <span class="pageSmall"><?php echo $dopage->GetList(); ?></span>
        </div>
		<div class="quickAreaBg"></div>
	</div>
</div>
<?php
}
?>

</body>
</html>
