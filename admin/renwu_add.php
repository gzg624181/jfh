<?php require_once(dirname(__FILE__).'/inc/config.inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员快速上分</title>
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
<div class="formHeader">快速上分<a href="javascript:location.reload();" class="reload">刷新</a> </div>
<form name="form" id="form" method="post" action="active_save.php" onsubmit="return cfm_renwu();">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
         <tr>
              <td height="40" align="right">搜索：</td>
        <td colspan="4" valign="middle"><select name="mtype" id="mtype" class="input">
                    <option value="-1">请选择任务类型</option>
                    <option value="list">任务列表</option>
                    <option value="complete">任务达成</option>
                    <option value="xuzhi">任务须知</option>
                  </select>
        </td>
            </tr>
      <tr>
      <td height="40" align="right">&nbsp;</td>
       <td><div class="formSubBtn" style="float:left; margin-top:5px;">
    <input type="submit" class="submit" value="搜索" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input type="hidden" name="action" id="action" value="quick_scroing" />
  </div></td>
    </tr>
	</table>

</form>
</body>
</html>
