<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加收款账号</title>
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
<script>

  function changetype(){

	  var options=$("#type option:selected");
	  var typename=options.val();
	  if(typename=="bankpay"){
	  var banknames = document.getElementById("banknames");
	  var lastbanknames = document.getElementById("lastbanknames");
	  banknames.style.display = "";
	  lastbanknames.style.display = "";
	  }else{
	  banknames.style.display = "none";
	  lastbanknames.style.display = "none";
		  }
  }

</script>
</head>
<body>
<div class="formHeader">添加收款账号<a href="javascript:location.reload();" class="reload">刷新</a> </div>
<form name="form" id="form" method="post" action="shoukuan_save.php" onsubmit="return cfm_account();">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr>
		  <td height="40" align="right">账户名：</td>
		  <td colspan="11"><input type="text" name="name" id="name" class="input"/></td>
    </tr>
		<tr>
		  <td height="47" align="right">充值方式：</td>
		  <td colspan="11"><select name="type" id="type" class="input" onchange="return changetype();">

        <?php
         $dosql->Execute("SELECT * FROM pmw_bank");
         while($r=$dosql->GetArray()){
         ?>
        <option  value="<?php echo $r['types'] ?>"><?php echo $r['typename']; ?></option>
        <?php } ?>
  	      </select>

	      </select></td>
    </tr>
		<tr>
			<td width="8%" height="40" align="right">充值账号：</td>
			<td colspan="11"><input type="text" name="account" id="account" class="input"/></td>
		</tr>

		<tr style="display:none" id="banknames">
			<td height="40" align="right">银行名称：</td>
			<td colspan="11" valign="middle">
             <input type="text" name="bankname" id="bankname" class="input" />
				</td>
	  </tr>

      <tr style="display:none" id="lastbanknames">
          <td height="40" align="right">卡支行：</td>
          <td colspan="11" valign="middle"><input type="text" name="lastbankname" id="lastbankname" class="input"/></td>
     </tr>
      <tr>
	  <td height="40" align="right">是否启用：</td>
		  <td colspan="3"><p>
          <label>
		      <input type="radio" name="online" value="1" checked='checked' id="online" />
		      启用
          </label>
          &nbsp;&nbsp;
		    <label>
		      <input name="none" type="radio" id="online" value="0" />
		      离线</label><br />
	      </p></td>
		  <td width="4%" align="right">&nbsp;</td>
		  <td width="5%">&nbsp;</td>
		  <td width="4%" align="right">&nbsp;</td>
		  <td width="5%" id="hot2">&nbsp;</td>
		  <td width="3%" align="right">&nbsp;</td>
		  <td width="5%" id="leixing2">&nbsp;</td>
		  <td width="3%" align="right">&nbsp;</td>
		  <td width="35%"  id="countrys2">&nbsp;</td>
    </tr>
      <tr>
		  <td height="272" align="right">充值账号备注：</td>
		  <td colspan="11"><textarea name="tips" id="tips" class="kindeditor"></textarea>
				<script>
				var editor;
				KindEditor.ready(function(K) {
					editor = K.create('textarea[name="tips"]', {
						allowFileManager : true,
						width:'100%',
						height:'365px',
						extraFileUploadParams : {
							sessionid :  '<?php echo session_id(); ?>'
						}
					});
				});
				</script>			<div id="fenlei" style="font-size:12px; color:#ffa8a8;display:inline;"></div></td>
	  </tr>
      <tr>
        <td height="40" align="right">排列排序：</td>
        <td width="16%"><input type="text" name="orderid" id="orderid" class="inputos" value="<?php echo GetOrderID('#@__shoukuan'); ?>" /></td>
      </tr>
      <tr>
      <td height="40" align="right">&nbsp;</td>
       <td><div class="formSubBtn" style="float:left; margin-top:5px;">
        <input type="submit" class="submit" value="保存" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input type="hidden" name="action" id="action" value="add" />
  </div></td>
    </tr>
	</table>

</form>
</body>
</html>
