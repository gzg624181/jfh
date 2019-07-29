<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('message'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- <meta http-equiv="refresh" content="10"> -->
<title>会员单日盈亏统计</title>
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
 layer.alert("请输入开奖期数！",{icon:0});
 $("#keyword").focus();
 return false;
}
window.location.href='lottery.php?keyword='+keyword;
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

<div class="topToolbar"> <span class="title">系统后台盈亏统计</span>
</span> <a href="javascript:location.reload();" class="reload">刷新</a></div>

</div>
<div class="toolbarTab" style="margin-bottom:5px;">
<ul>
 <li class="<?php if($check==""){echo "on";}?>"><a href="win_lost.php">今天统计</a></li> <li class="line">-</li>
 <li class="<?php if($check=="tomorrow"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('tomorrow')">昨天统计</a></li>
 <li class="line">-</li>
 <li class="<?php if($check=="week"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('week')">本周统计</a></li>
 <li class="line">-</li>
 <li class="<?php if($check=="month"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('month')">本月统计</a></li>
 <li class="line">-</li>
 <li class="<?php if($check=="all"){echo "on";}?>"><a href="javascript:;" onclick="checkinfo('all')">累计统计</a></li>
	</ul>
	<div id="search" class="search"> <span class="s">
<input name="keyword" id="keyword" type="text" class="number" style="font-size:11px;" placeholder="请输入开奖期数" title="请输入开奖期数" />
		</span> <span class="b"><a href="javascript:;" onclick="GetSearchs();"></a></span></div>
	<div class="cl"></div>
</div>
<form name="form" id="form" method="post" action="lotter_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
		<tr >
			<td width="2%" height="36" align="center" class="firstCol"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="5%" align="center">推荐码ID</td>
			<td width="13%" align="center">会员昵称</td>
			<td width="12%" align="center">会员账号</td>
			<td width="20%" align="center">统计时间</td>
			<td width="14%" align="center">下注总金额</td>
			<td width="14%" align="center">中奖总金额</td>
			<td width="12%" align="center">实际盈亏</td>
			<td width="10%" align="center">操作</td>
		</tr>
		<?php
    $xiazhu_ymd = date("Y-m-d");   //今天的日期

		if($keyword!=""){              //选中具体的日期
	  $dopage->GetPage("SELECT * FROM `#@__lotterynumber` where kj_times='$keyword'");
		}elseif($check=="tomorrow"){    //昨天

    $xiazhu_ymd=date("Y-m-d",strtotime("-1 day"));
  	$dopage->GetPage("SELECT a.*,b.ucode,b.nickname,b.telephone FROM `#@__xiazhuorder` a inner join pmw_members b on a.uid=b.id where a.xiazhu_ymd='$xiazhu_ymd' group by a.uid");
    }elseif($check=="week"){       //本周(从本周星期一开始计算，到本周星期日结束)
      $arr = get_times();
      $starttime = $arr['this_mon_timestamp']; // 本周星期一开始时间
      $endtime   = $arr['this_sun_timestamp']+24*3600; // 本周星期日开始时间
    	$dopage->GetPage("SELECT a.*,b.ucode,b.nickname,b.telephone FROM `#@__xiazhuorder` a inner join pmw_members b on a.uid=b.id where a.xiazhu_timestamp >= $starttime and a.xiazhu_timestamp < $endtime group by a.uid");

    }elseif($check=="month"){        //本月
      $arr = get_times();
      $starttime = $arr['beginDate_timestamp']; // 本月第一天开始时间
      $endtime   = $arr['lastDate_timestamp']+24*3600; // 本月最后一天时间
      $dopage->GetPage("SELECT a.*,b.ucode,b.nickname,b.telephone FROM `#@__xiazhuorder` a inner join pmw_members b on a.uid=b.id where a.xiazhu_timestamp >= $starttime and a.xiazhu_timestamp < $endtime group by a.uid");

    }elseif($check=="all"){           //累计
		$dopage->GetPage("SELECT a.*,b.ucode,b.nickname,b.telephone FROM `#@__xiazhuorder` a inner join pmw_members b on a.uid=b.id group by a.uid ");
		}else{
		$dopage->GetPage("SELECT a.*,b.ucode,b.nickname,b.telephone FROM `#@__xiazhuorder` a inner join pmw_members b on a.uid=b.id where a.xiazhu_ymd='$xiazhu_ymd' group by a.uid ");
		}

		while($row = $dosql->GetArray())
		{
      //  计算单个用户当天的下注总额和中奖总额
      $uid = $row['uid'];

      if($check =="week"){

        $arr = get_times();
        $starttime = $arr['this_mon_timestamp']; // 本周星期一开始时间
        $endtime   = $arr['this_sun_timestamp']+24*3600; // 本周星期日开始时间
        $r = $dosql->GetOne("SELECT SUM(xiazhu_sum) as xiazhu_sum,SUM(xiazhu_jiangjin) as xiazhu_jiangjin FROM pmw_xiazhuorder where uid=$uid and xiazhu_timestamp >= $starttime and xiazhu_timestamp < $endtime");
        $xiazhu_ymd = $arr['this_mon_ymd']."----".$arr['this_sun_ymd'];

      }elseif($check=='' || $check=='tomorrow'){
        $r = $dosql->GetOne("SELECT SUM(xiazhu_sum) as xiazhu_sum,SUM(xiazhu_jiangjin) as xiazhu_jiangjin FROM pmw_xiazhuorder where uid=$uid and xiazhu_ymd='$xiazhu_ymd' and xiazhu_kjstate=1");

      }elseif($check=="month"){

        $arr = get_times();
        $starttime = $arr['beginDate_timestamp']; // 本月第一天开始时间
        $endtime   = $arr['lastDate_timestamp']+24*3600; // 本月最后一天时间
        $r = $dosql->GetOne("SELECT SUM(xiazhu_sum) as xiazhu_sum,SUM(xiazhu_jiangjin) as xiazhu_jiangjin FROM pmw_xiazhuorder where uid=$uid and xiazhu_timestamp >= $starttime and xiazhu_timestamp < $endtime");

        $xiazhu_ymd = $arr['beginDate']."----".$arr['lastDate'];

      }elseif($check=="all"){

        $r = $dosql->GetOne("SELECT SUM(xiazhu_sum) as xiazhu_sum,SUM(xiazhu_jiangjin) as xiazhu_jiangjin, MIN(xiazhu_timestamp) as  firsttime, MAX(xiazhu_timestamp) as lasttime FROM pmw_xiazhuorder where uid=$uid");

        $xiazhu_ymd = date("Y-m-d",$r['firsttime'])."----".date("Y-m-d",$r['lasttime']);
      }

      $xiazhu_sum = $r['xiazhu_sum'];

      $xiazhu_jiangjin = $r['xiazhu_jiangjin'];

      $yingkui = $xiazhu_jiangjin - $xiazhu_sum;

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
			<td align="center">
			<span><a href="xiazhu_list.php?uid=<?php echo $row['uid']; ?>&xiazhu_ymd=<?php echo $xiazhu_ymd;?>"><i title="查看下单详情" class="fa fa-eye fa-fw" aria-hidden="true"></i></a></span>

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
