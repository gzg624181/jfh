<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('message'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- <meta http-equiv="refresh" content="10"> -->
<title>会员单日回水操作</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

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
window.location.href='fanshui.php?keyword='+keyword;
}
  function checkinfo(key){
     var v= key;
	// alert(v)
	window.location.href='win_lost.php?check='+v;
	}


</script>
<?php
//初始化参数

$action  = isset($action)  ? $action  : '';
$keyword = isset($keyword) ? $keyword : '';
$check = isset($check) ? $check : '';
?>
</head>
<body>
<?php
if($keyword==""){
$xiazhu_ymd=date("Y-m-d",strtotime("-1 day"));
}else{
$xiazhu_ymd =$keyword;
}
//计算所有会员的会员总额
$k = $dosql->GetOne("SELECT SUM(money) as money from pmw_huishui where tj_time='$xiazhu_ymd'");
if($k['money']!= NULL){
$huishui_allmoney = $k['money'];
}else{
$huishui_allmoney = 0;
}
?>

<div class="topToolbar">
<span class="title">当前回水操作日期：<span class="num" style="color:red;"><?php echo $xiazhu_ymd;?></span>
</span>

<span class="title" style="margin-left:11px;">今天回水总额：<span class="num" style="color:red;"><?php echo $huishui_allmoney;?></span>
</span>
 <a href="javascript:location.reload();" class="reload">刷新</a></div>

</div>
<div class="toolbarTab" style="margin-bottom:5px;">
<div id="search" class="search"> <span class="s">
<input name="keyword" id="keyword" type="text" class="number" style="font-size:11px;" placeholder="请输入回水操作日期" title="请输入回水操作日期" />
		</span> <span class="b"><a href="javascript:;" onclick="GetSearchs();"></a></span></div>
	<div class="cl"></div>
</div>
<form name="form" id="form" method="post" action="lotter_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
		<tr >
			<td width="2%" height="36" align="center" class="firstCol"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="5%" align="center">推荐码ID</td>
			<td width="13%" align="center">会员昵称</td>
			<td width="10%" align="center">会员账号</td>
			<td width="10%" align="center">统计时间</td>
			<td width="10%" align="center">下注总金额</td>
			<td width="10%" align="center">中奖总金额</td>
			<td width="10%" align="center">实际盈亏</td>
      <td width="12%" align="center">回水总金额</td>
      <td width="12%" align="center">是否已设置回水</td>
			<td width="12%" align="center">操作</td>
		</tr>
		<?php
		if($keyword!=""){              //选中具体的日期
    $torrow  =strtotime(date("Y-m-d",strtotime("-1 day")));
    $keywords =strtotime($keyword);
      if($keywords <= $torrow){
  	  $dopage->GetPage("SELECT a.*,b.ucode,b.nickname,b.telephone FROM `#@__xiazhuorder` a inner join pmw_members b on a.uid=b.id where a.xiazhu_ymd='$keyword' group by a.uid ");
      }else{
        ShowMsg('抱歉，日期选择错误,只能操作今天之后的回水日期','-1');
    		exit();
      }
		}else{
		$dopage->GetPage("SELECT a.*,b.ucode,b.nickname,b.telephone FROM `#@__xiazhuorder` a inner join pmw_members b on a.uid=b.id where a.xiazhu_ymd='$xiazhu_ymd' group by a.uid ");
		}

		while($row = $dosql->GetArray())
		{
      //  计算单个用户当天的下注总额和中奖总额
      $uid = $row['uid'];

      $r = $dosql->GetOne("SELECT SUM(xiazhu_sum) as xiazhu_sum,SUM(xiazhu_jiangjin) as xiazhu_jiangjin FROM pmw_xiazhuorder where uid=$uid and xiazhu_ymd='$xiazhu_ymd' and xiazhu_kjstate=1");

      $xiazhu_sum = $r['xiazhu_sum'];

      $xiazhu_jiangjin = $r['xiazhu_jiangjin'];

      $yingkui = $xiazhu_jiangjin - $xiazhu_sum;

      //计算单个会员当天回水的总额
      $s = $dosql->GetOne("SELECT SUM(money) as money from pmw_huishui where uid=$uid and tj_time='$xiazhu_ymd'");
      if($s['money']!= NULL){
      $huishui_money = $s['money'];
      $huishui_state = "<i title='已进行回水操作' style='color:#509ee1' class='fa fa-check'></i>";
      }else{
      $huishui_money = "";
      $huishui_state = "";
      }
		?>
		<tr align="left" class="dataTr">
			<td height="60" align="center" class="firstCol"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td align="center"  class="number"><?php echo $row['ucode']; ?></td>
			<td align="center"  class="number"><?php echo $row['nickname']; ?></td>
			<td align="center" class="number"><?php echo $row['telephone']; ?></td></td>
			<td align="center" class="number"><?php echo $xiazhu_ymd; ?></td>
			<td align="center" class="num" style="color:#990808"><?php echo $xiazhu_sum; ?></td>
			<td align="center" class="num" style="color:#990808"><?php  echo $xiazhu_jiangjin; ?></td>
			<td align="center" class="num" style="color:#30b70f"><?php  echo $yingkui; ?></td>
      <td align="center" class="num" style="color:#30b70f"><?php  echo $huishui_money;?></td>
      <td align="center" class="num" style="color:#30b70f"><?php echo $huishui_state; ?></td>
			<td align="center">

        <span>
        <a href="fanhui_take.php?uid=<?php echo $row['uid']; ?>&xiazhu_ymd=<?php echo $xiazhu_ymd;?>&yingkui=<?php echo $yingkui;?>"><i title="点击进行回水操作" class="fa fa-undo fa-fw" aria-hidden="true"></i></a>
        </span>
        &nbsp;
			<span>
      <a href="xiazhu_list.php?uid=<?php echo $row['uid']; ?>&xiazhu_ymd=<?php echo $xiazhu_ymd;?>"><i title="查看下注详情" class="fa fa-eye fa-fw" aria-hidden="true"></i></a>
      </span>

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
<div class="bottomToolbar"><span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('lottery_save.php');" onclick="return ConfDelAll(0);">删除</a></span>  </div>
<div class="page"> <?php echo $dopage->GetList(); ?> </div>
<?php

//判断是否启用快捷工具栏
if($cfg_quicktool == 'Y')
{
?>
<div class="quickToolbar">
	<div class="qiuckWarp">
		<div class="quickArea"><span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('lotter_save.php');" onclick="return ConfDelAll(0);">删除</a></span> <span class="pageSmall"> <?php echo $dopage->GetList(); ?> </span></div>
		<div class="quickAreaBg"></div>
	</div>
</div>
<?php
}
?>
<script type="text/javascript" src="layui/layui.js"></script>
<script>
layui.use('laydate', function(){
  var laydate = layui.laydate;
  laydate.render({
    elem: '#keyword'
  });

});


</script>
</body>
</html>
