<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>充值方式</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<link href="templates/style/menu1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/listajax.js"></script>
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
<script type="text/javascript" src="layer/layer.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php
//初始化参数
$action  = isset($action)  ? $action  : '';
$keyword = isset($keyword) ? $keyword : '';
$check = isset($check) ? $check : '';

?>
<div class="topToolbar"  style="margin-bottom: -14px;"> <span class="title">充值列表</span>
<a href="javascript:location.reload();" class="reload">刷新</a>
</div>
<form name="form" id="form" method="post" action="product_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
		<tr align="left" class="head">
			<td width="3%" height="36" align="center"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td align="center">支付类别简写</td>
			<td width="60%" align="center">支付类别名称</td>
			<td width="20%" align="center">创建时间</td>
			<td width="3%" align="center">操作</td>
		</tr>
		<?php
		$username=$_SESSION['admin'];
		$adminlevel=$_SESSION['adminlevel'];

		$dopage->GetPage("SELECT * FROM `pmw_bank`",10);

		while($row = $dosql->GetArray())
		{
		?>
		<tr align="left" class="dataTr">
		<td height="59" align="center"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
		  <td align="center"><?php echo $row['types']; ?></td>
			<td align="center" class="num"><?php echo $row['typename']; ?></td>
			<td align="center"><span class="number"><?php echo date("Y-m-d H:i:s",$row['addtime']); ?></span></td>
			<td align="center">
 <div id="jsddm"><a title="删除" href="way_save.php?action=del6&id=<?php echo $row['id'];?>" onclick="return ConfDel(0);">
 <i class="fa fa-trash" aria-hidden="true"></i></a></div>
 <div id="jsddm"><a title="编辑" href="way_update.php?id=<?php echo $row['id'];?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></div>

            </td>
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
<div class="bottomToolbar"> <span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('way_save.php');" onclick="return ConfDelAll(0);">删除</a></span> <a href="way_add.php" class="dataBtn">新增支付方式</a> </div>
<div class="page"> <?php echo $dopage->GetList(); ?> </div>
<?php
//判断是否启用快捷工具栏
if($cfg_quicktool == 'Y')
{
?>
<div class="quickToolbar">
	<div class="qiuckWarp">
		<div class="quickArea">
        <a href="way_add.php" class="dataBtn">新增支付方式</a> <span class="pageSmall"><?php echo $dopage->GetList(); ?></span>
        </div>
		<div class="quickAreaBg"></div>
	</div>
</div>
<?php
}
?>
</body>
</html>
