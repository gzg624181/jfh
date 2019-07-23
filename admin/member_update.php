<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('member'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改会员</title>
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
<script type="text/javascript" src="templates/js/ajax.js"></script>
<script type="text/javascript" src="layer/layer.js"></script>
<script>

function changeimages(id){
  layer.open({
  type: 2,
  title: '<span style="color:#000;"><b>选择头像</b></span>',
  maxmin: true,
  shadeClose: true, //点击遮罩关闭	层
  area : ['450px' , '650px'],
  content: 'imageslist.php?id='+id,
  });
}

</script>
</head>
<body>
<?php
$row = $dosql->GetOne("SELECT * FROM `#@__members` WHERE id='$id'");
if($row['images']==""){
			$images="../templates/default/images/noimage.jpg";
		    }else{
            $images="./templates/images/avatar/".$row['images'].".jpg";
            }
$adminlevel=$_SESSION['adminlevel'];
?>
<div class="formHeader"> <span class="title">修改会员</span> <a href="javascript:location.reload();" class="reload">刷新</a> </div>
<form name="form" id="form" method="post" action="member_save.php" onsubmit="return cfm_up();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr>
			<td width="25%" height="40" align="right">账　号：</td>
			<td width="75%"><strong><?php echo $row['telephone']; ?></strong></td>
		</tr>
		<tr>
			<td height="40" align="right">提现姓名：</td>
			<td><input name="getname" type="text" class="input" id="getname" value="<?php echo $row['getname']; ?>" /></td>
		</tr>
		<tr>
			<td height="40" align="right">昵　称：</td>
			<td><input type="text" name="nickname" id="nickname" class="input" value="<?php echo $row['nickname']; ?>" /></td>
		</tr>
		<tr>
			<td height="40" align="right">Q　Q：</td>
			<td><input type="text" name="qq" id="qq" class="input" value="<?php echo $row['qq']; ?>" /></td>
		</tr>
        <tr>
			<td height="40" align="right">推荐码：</td>
			<td><input type="text" readonly="readonly" name="ucode" id="ucode" class="input" value="<?php echo $row['ucode']; ?>" /></td>
		</tr>
        <tr>
			<td height="40" align="right">推荐人：</td>
			<td><input type="text" readonly="readonly" name="bcode" id="bcode" class="input" value="<?php
			$bcode=$row['bcode'];
			if($bcode==""){
				echo "";
			}else{
			 $r = $dosql->GetOne("SELECT telephone FROM `#@__members` WHERE ucode=$bcode");
			 if(is_array($r)){
				 echo $r['telephone'];
			     }else{
				 echo "";
				 }
			}
		    ?>" /></td>
		</tr>
		<tr>
			<td height="112" align="right">头　像：</td>
			<td><div id="layer-photos-demo_<?php echo $row['id'];?>" class="layer-photos-demo">
     <img id="changepic" class="changepic"  width="100px;" style="cursor:pointer" title="修改头像请点击图片进行更换" onclick="changeimages('<?php echo $row['id']; ?>');"  src="<?php echo $images;?>" alt="<?php echo $row['nickname']; ?>" />
          <input type="hidden" name="images" id="images" value="<?php echo $row['images'];?>" />
       </div>
				<div class="hr_10" style="height: 0px;"></div>

          </td>
		</tr>
		<tr>
			<td height="40" align="right">注册时间：</td>
			<td><input type="text" name="ymdtime" id="ymdtime" class="input"  value="<?php echo date("Y-m-d H:i:s",$row['regtime']); ?>"  /></td>
		</tr>
        <?php
		if($adminlevel==1){
		?>
		<tr>
			<td height="40" align="right">账户余额：</td>
			<td><input type="text" name="money" id="money" class="input" readonly  value="<?php echo $row['money']; ?>"  /></td>
		</tr>
        <?php }?>
	</table>
	<div class="formSubBtn">
		<input type="submit" class="submit" value="提交" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input type="hidden" name="action" id="action" value="update" />
		<input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>" />
  </div>
</form>
</body>
</html>
