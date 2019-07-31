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
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="layer/layer.js"></script>
<script>
function GetSearchs(){
var keyword= document.getElementById("keyword").value;
if($("#keyword").val() == "")
{
 layer.alert("请输入开奖期数！",{icon:0});
 $("#keyword").focus();
 return false;
}
window.location.href='fanshui.php?keyword='+keyword;
}
function add_huishui(uid,xiazhu_ymd,gameid,yingkui) {
  layer.open({
    type: 2,
    title: '',
    maxmin: true,
    shadeClose: true, //点击遮罩关闭	层
    area : ['480px' , '350px'],
    content: 'add_huishui.php?uid='+uid+'&xiazhu_ymd='+xiazhu_ymd+'&gameid='+gameid+'&yingkui='+yingkui,
    });

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
$r = $dosql->GetOne("SELECT * FROM pmw_members where id=$uid");
//计算所有会员的会员总额
$k = $dosql->GetOne("SELECT SUM(money) as money from pmw_huishui where tj_time='$xiazhu_ymd' and uid=$uid");
if($k['money']!= NULL){
$huishui_allmoney = $k['money'];
}else{
$huishui_allmoney = 0;
}
?>
</head>
<body>
<div class="topToolbar"> <span class="title">当前回水操作日期：<span class="num" style="color:red;"><?php echo $xiazhu_ymd;?></span>
</span>
<span style="margin-left:11px;" class="title">用户昵称：<span class="num" style="color:red;"><?php echo $r['nickname'];?></span>
</span>

<span style="margin-left:11px;" class="title">实际盈亏：<span class="num" style="color:red;"><?php echo $yingkui;?></span>
</span>

<span style="margin-left:11px;" class="title">回水总额：<span class="num" style="color:red;"><?php echo $huishui_allmoney;?></span>
</span>
<a href="javascript:location.reload();" class="reload">刷新</a></div>

</div>

<form name="form" id="form" method="post" action="lotter_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
		<tr >
			<td width="2%" height="36" align="center" class="firstCol"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="13%" align="center">游戏类别</td>
			<td width="11%" align="center">下注次数</td>
			<td width="12%" align="center">会员账号</td>
			<td width="12%" align="center">统计时间</td>
			<td width="11%" align="center">下注总金额</td>
			<td width="11%" align="center">中奖总金额</td>
			<td width="12%" align="center">实际盈亏</td>
      <td width="11%" align="center">回水金额</td>
			<td width="10%" align="center">操作</td>
		</tr>
		<?php

		$dopage->GetPage("SELECT a.*,b.gametypes FROM `#@__xiazhuorder` a inner join pmw_game b on a.gameid=b.id where a.uid=$uid and a.xiazhu_ymd='$xiazhu_ymd' and a.xiazhu_kjstate=1 group by a.gameid ");

		while($row = $dosql->GetArray())
		{
      //  计算单个类别的游戏的盈亏额度
      $gameid = $row['gameid'];

      $k = $dosql->GetOne("SELECT SUM(xiazhu_sum) as xiazhu_sum,SUM(xiazhu_jiangjin) as xiazhu_jiangjin FROM pmw_xiazhuorder where uid=$uid and xiazhu_ymd='$xiazhu_ymd' and xiazhu_kjstate=1 and gameid=$gameid");

      $xiazhu_sum = $k['xiazhu_sum'];

      $xiazhu_jiangjin = $k['xiazhu_jiangjin'];

      $yingkuis = $xiazhu_jiangjin - $xiazhu_sum;

      // 计算下注的次数

      $one=1;
      $dosql->Execute("SELECT id from pmw_xiazhuorder where uid=$uid and xiazhu_ymd='$xiazhu_ymd' and xiazhu_kjstate=1 and gameid=$gameid group by xiazhu_qishu",$one);
      $nums = $dosql->GetTotalRow($one);

      //判断是否已经给此用户的此款游戏回过水
      $sow = $dosql->GetOne("SELECT money from pmw_huishui where gameid=$gameid and uid=$uid and tj_time='$xiazhu_ymd' and yingkui_money='$yingkuis'");
      if(is_array($sow)){
        $huishui_money = $sow['money'];
      }else{
        $huishui_money = "";
      }

		?>
		<tr align="left" class="dataTr">
			<td height="60" align="center" class="firstCol"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td align="center"  class="number"><?php echo $row['gametypes']; ?></td>
			<td align="center"  class="number"><?php echo $nums; ?></td>
			<td align="center" class="number"><?php echo $r['telephone']; ?></td></td>
			<td align="center" class="number"><?php echo $xiazhu_ymd; ?></td>
			<td align="center" class="num" style="color:#990808"><?php echo $xiazhu_sum; ?></td>
			<td align="center" class="num" style="color:#990808"><?php  echo $xiazhu_jiangjin; ?></td>
      <td align="center" class="num" style="color:#30b70f"><?php  echo $yingkuis; ?></td>
      <td align="center" class="num" style="color:#529ee0"><?php  echo $huishui_money;  ?></td>
			<td align="center">
      <?php if($huishui_money==""){ ?>
        <span>
        <a style="cursor:pointer" onclick="add_huishui('<?php echo $row['uid'] ?>','<?php echo $xiazhu_ymd ?>','<?php echo $gameid; ?>','<?php echo $yingkuis; ?>')">
        <i title="点击进行回水加分操作" class="fa fa-dollar fa-fw" aria-hidden="true"></i></a>
        </span>
      <?php }else{ ?>
        <span>
        <i title="此款游戏的回水已经添加！" class="fa fa-telegram fa-fw" aria-hidden="true"></i>
        </span>
      <?php } ?>
        &nbsp;
			<span>
      <a href="xiazhu_list.php?uid=<?php echo $row['uid']; ?>&xiazhu_ymd=<?php echo $xiazhu_ymd;?>&gameid=<?php echo $gameid;?>"><i title="查看下注详情" class="fa fa-eye fa-fw" aria-hidden="true"></i></a>
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
</body>
</html>
