<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>首页banner图片列表管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<link href="templates/style/menu1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="topToolbar"> <span class="title">首页banner图片列表</span> <a href="javascript:location.reload();" class="reload">刷新</a></div>
<form name="form" id="form" method="post" action="banner_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
		<tr align="left" class="head">
			<td width="1%" height="36" align="center">&nbsp;</td>
		  <td width="30%" align="center">文字介绍</td>
		  <td width="31%" align="center">banner图片</td>
		  <td width="35%" align="center">添加时间</td>
		  <td width="3%" align="center">操作</td>
		</tr>
		<?php
		$dosql->Execute("SELECT * FROM `pmw_banner`");
		while($row = $dosql->GetArray())
		{
		?>
		<tr align="left" class="dataTr">
			<td height="54" align="center">&nbsp;</td>
			<td align="center"><?php echo $row['title'];?></td>
			<td align="center"><img style="width:200px; padding:5px;border-radius: 9px; " src="<?php echo $row['pic'];?>"></td>
			<td align="center"><?php echo date("Y-m-d H:i:s",$row['pictime']);?></td>
			<td align="center">
      <div id="jsddm">
			<a title="编辑"  href="banner_update.php?id=<?php echo $row['id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></div>
    <div id="jsddm" style=" margin-top:3px;"><a title="删除" href="banner_save.php?action=del2&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0);"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
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
<div class="formSubBtn" style="text-align:left; margin-left:50px; margin-top:20px;">
<input type="button" class="back" value="返回" onclick="history.go(-1);" />
	</div>
</body>
</html>
