<?php require_once(dirname(__FILE__).'/inc/config.inc.php');
$username=$_SESSION['admin'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<link href="templates/style/menu1.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="layer/layer.js"></script>
<script>
function message(Id){
  // alert(Id);
   layer.ready(function(){ //为了layer.ext.js加载完毕再执行
   layer.photos({
   photos: '#layer-photos-demo_'+Id,
	 area:['300px','270px'],  //图片的宽度和高度
   shift: 0 ,//0-6的选择，指定弹出图片动画类型，默认随机
   closeBtn:1,
   offset:'40px',  //离上方的距离
   shadeClose:false
  });
});
}

function erweima_tuijian(id)
{
layer.open({
  type: 2,
  title: '推荐二维码：',
  maxmin: true,
  shadeClose: true, //点击遮罩关闭	层
  area : ['500px' , '385px'],
  content: 'erweima_tuijian.php?id='+id,
  });
}

function xiazhuorder(id,nickname)
{
layer.open({
  type: 2,
  title: nickname +'下注记录：',
  maxmin: true,
  shadeClose: true, //点击遮罩关闭	层
  area : ['80%' , '685px'],
  content: 'member_order.php?id='+id,
  });
}
function pay_add(id)
{
layer.open({
  type: 2,
  title: '',
  maxmin: true,
  shadeClose: true, //点击遮罩关闭	层
  area : ['480px' , '320px'],
  content: 'pay_add.php?id='+id,
  });
}
function tuijian_shopping(recommand)
{
layer.open({
  type: 2,
  title: '下线记录：',
  maxmin: true,
  shadeClose: true, //点击遮罩关闭	层
  area : ['900px' , '655px'],
  content: 'tuijian_shopping.php?ucode='+recommand,
  });
}
function paylist(id,uid,nickname)
{
layer.open({
  type: 2,
  title: '会员充值记录：',
  maxmin: true,
  shadeClose: true, //点击遮罩关闭	层
  area : ['900px' , '655px'],
  content: 'paylist.php?id='+id+'&uid='+uid+'&nickname='+nickname,
  });
}

function pickmoney(id,telephone)
{
layer.open({
  type: 2,
  title: '会员提现账号：',
  maxmin: true,
  shadeClose: true, //点击遮罩关闭	层
  area : ['900px' , '655px'],
  content: 'pickmoney.php?id='+id+'&telephone='+telephone,
  });
}

function GetSearchs(){
var keyword= document.getElementById("keyword").value;
if($("#keyword").val() == "")
{
 layer.alert("请输入搜索内容！",{icon:0});
 $("#keyword").focus();
 return false;
}
window.location.href='member.php?keyword='+keyword;
}
function member_update(Id){
 var adminlevel=document.getElementById("adminlevel").value;
  if(adminlevel==1){
	  window.location("member_update.php?id="+Id);
    }else{
	  alert("亲，您还没有操作本模块的权限，请联系超级管理员！");
		}
	}

function del_member(){
 var adminlevel=document.getElementById("adminlevel").value;
  if(adminlevel!=1){
	  alert("亲，您还没有操作本模块的权限，请联系超级管理员！");
  }
	}
</script>


<?php
//初始化参数
$action  = isset($action)  ? $action  : '';
$keyword = isset($keyword) ? $keyword : '';
$check = isset($check) ? $check : '';
$username=$_SESSION['admin'];
$adminlevel=$_SESSION['adminlevel'];
$r=$dosql->GetOne("select * from pmw_admin where username='$username'");

?>
</head>
<body>
<?php
$one=1;
$dosql->Execute("SELECT * FROM `#@__members`",$one);
$num=$dosql->GetTotalRow($one);
?>
<input type="hidden" name="adminlevel" id="adminlevel" value="<?php echo $adminlevel;?>" />
<div class="topToolbar"> <span class="title">会员合计：<span class="num" style="color:red;"><?php echo $num;?></span>
</span> <a href="javascript:location.reload();" class="reload">刷新</a>
<!-- <a onClick="return confirm('确认更新所有会员缓存？');"   style="width:100px; color:#e44410;font-weight: bold;" href="member_save.php?action=update_cache" class="reload">更新会员缓存</a> -->
</div>
<div class="toolbarTab" style="margin-bottom:-12px;">
	<div id="search" class="search"> <span class="s">
<input name="keyword" id="keyword" type="text" class="number" style="font-size:11px;" placeholder="请输入用户账号或者昵称" title="请输入用户账号或者昵称" />
		</span> <span class="b"><a href="javascript:;" onclick="GetSearchs();"></a></span></div>
	<div class="cl"></div>
</div>
<form name="form" id="form" method="post" action="member_save.php">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
  <tr align="left" class="head">
    <td width="3%" align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
      <tr align="left" class="head">
        <td width="3%" align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
          <tr align="left" class="head">
            <td width="3%" height="144" align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
              <tr align="left" class="head" style="font-weight:bold;">
                <td width="1%" height="36" align="center"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);" /></td>
                <td width="9%" align="center">用户账号</td>
                <td width="7%" align="center">头像</td>
                <td width="8%" align="center">昵称</td>
                <td width="9%" align="center">推荐码</td>
                <td width="10%" align="center">推荐人</td>
                <td width="8%" align="center">提现姓名</td>
                <td width="6%" align="center">登陆设备码</td>
                <td width="8%" align="center">绑定QQ</td>
                <td width="7%" align="center">账户余额</td>
                <td width="10%" align="center">最后登陆城市</td>
                <td width="11%" align="center">注册时间</td>
                <td width="3%" align="center">操作</td>
              </tr>
              <?php
		if($check=="today"){
		$time=date("Y-m-d");
		$dopage->GetPage("select * from `pmw_members` where ymdtime like '%$time%'",15);
	    }elseif($check=="tomorrowzhuce"){
		$time=date("Y-m-d",strtotime("-1 day"));
		$dopage->GetPage("select * from `pmw_members` where ymdtime like '%$time%'",15);
	    }elseif($keyword!=""){
	    $dopage->GetPage("SELECT * FROM `pmw_members` where telephone like '%$keyword%' or nickname  like '%$keyword%' ",15);
		}else{
		$dopage->GetPage("SELECT * FROM `pmw_members`",15);
		}

		while($row = $dosql->GetArray())
		{
			switch($row['devicetype'])
			{
				case '1':
					$devicetype = "<i style='font-size:16px;color: #3339;' class='fa fa-apple' aria-hidden='true'></i>";
					break;
				case '0':
					$devicetype = "<i style='font-size:16px;color: #3339;' class='fa fa-android' aria-hidden='true'></i>";
					break;

			}
			if($row['images']==""){
			$images="../templates/default/images/noimage.jpg";
		    }else{
            $images="./templates/images/avatar/".$row['images'].".jpg";
            }
		?>
              <tr class="dataTr" align="left">
                <td height="97" align="center"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
                <td align="center"><?php echo $row['telephone']; ?></td>
                <td align="center"><div id="layer-photos-demo_<?php  echo $row['id'];?>" class="layer-photos-demo"> <img  width="100px;" layer-src="<?php echo $images;?>" style="cursor:pointer" onclick="message('<?php echo $row['id']; ?>');"  src="<?php echo $images;?>" alt="<?php echo $row['nickname']; ?>" /></div></td>
                <td align="center"><?php echo $row['nickname']; ?></td>
                <td align="center"><?php echo $row['ucode']; ?></td>
                <td align="center" class="num"><?php
			$bcode=$row['bcode'];
			if($bcode==""){
				echo "";
			}else{
			 $r = $dosql->GetOne("SELECT nickname FROM `#@__members` WHERE ucode=$bcode");
			 if(is_array($r)){
				 echo $r['nickname'];
			     }else{
				 echo "";
				 }
			}
		    ?></td>
                <td align="center" ><?php echo $row['getname']; ?></td>
                <td align="center"><?php echo $devicetype; ?></td>
                <td align="center"><?php echo $row['qq']; ?></td>
                <td align="center" class="num" style="color:red;"><?php echo sprintf("%.2f",$row['money']); ?></td>
                <td align="center"><?php
                if($row['getcity']=="" || $row['getcity']=="--"){
                // echo get_city($row['regip']);
				        echo "--";
                }else{
                 echo $row['getcity'];
                }
                 ?></td>
                <td align="center"><?php echo date("Y-m-d H:i:s",$row['regtime']);?></td>
                <td align="center">
                  <div id="jsddm" style="margin-top: 6px;margin-bottom: 8px;"><a title="后台充值" style="cursor:pointer" onclick="pay_add('<?php echo $row['id'];?>');"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></a></div>

                  <div id="jsddm" style="margin-top: 6px;margin-bottom: 8px;"><a title="充值记录" style="cursor:pointer" onclick="paylist('<?php echo $row['id'];?>','<?php echo $row['ucode'];?>','<?php echo $row['nickname'];?>');"><i class="fa fa fa-lastfm" aria-hidden="true"></i></a></div>

                  <div id="jsddm" style="margin-top: 6px;margin-bottom: 8px;"><a title="下注记录" style="cursor:pointer" onclick="xiazhuorder('<?php echo $row['id'];?>','<?php echo $row['nickname'];?>');"><i class="fa fa-chrome" aria-hidden="true"></i></a></div>

                  <div id="jsddm" style="margin-top: 6px;margin-bottom: 8px;"><a title="编辑会员信息" href="member_update.php?id=<?php echo $row['id']; ?>"><i class="fa fa-pencil-square-o fa-fw" aria-hidden="true"></i></a></div>

                </td>
                <td width="3%" align="center">
                  <div id="jsddm" style="margin-top: 6px;margin-bottom: 8px;"><a title="提现账号" style="cursor:pointer" onclick="pickmoney('<?php echo $row['id'];?>','<?php echo $row['telephone'];?>');"><i class="fa fa-clone" aria-hidden="true"></i></a></div>
                  <div id="jsddm" style="margin-top: 6px;margin-bottom: 8px;"><a title="推荐会员注册记录" style="cursor:pointer" onclick="tuijian_shopping('<?php echo $row['ucode'];?>');"><i class="fa fa-share" aria-hidden="true"></i></a></div>
                  <div id="jsddm" style="margin-top: 6px;margin-bottom: 8px;"><a title="推荐二维码" style="cursor:pointer" onclick="erweima_tuijian('<?php echo $row['id'];?>');"><i class="fa fa-skype" aria-hidden="true"></i></a></div>
                  <div id="jsddm" style="margin-top: 6px;margin-bottom: 8px;"><a title="删除" href="member_save.php?action=del2&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0);"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></a></div></td>
                <?php //}?>
              </tr>
              <?php
		}
		?>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  </table>
</form>
<?php

//

if($dosql->GetTotalRow() == 0)
{
	echo '<div class="dataEmpty">暂时没有相关的记录</div>';
}
?>
<div class="bottomToolbar"><span class="selArea"><span>选择：</span>
<a href="javascript:CheckAll(true);">全部</a> -
<a href="javascript:CheckAll(false);">无</a> -
<a href="javascript:DelAllNone('member_save.php');" onclick="return  ConfDelAll(0);">删除</a>
</span></div>
<div class="page"> <?php echo $dopage->GetList(); ?> </div>
<?php

//判断是否启用快捷工具栏
if($cfg_quicktool == 'Y')
{
?>
<div class="quickToolbar">
	<div class="qiuckWarp">
		<div class="quickArea"><span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('member_save.php');" onclick="return ConfDelAll(0);">删除</a>-
<a href="javascript:ConfsendReg('member_save.php');" onclick="return ConfDelAll(4);">发放注册奖励</a></span> <span class="pageSmall"> <?php echo $dopage->GetList(); ?></a> </span></div>
		<div class="quickAreaBg"></div>
	</div>

	</div>
<?php
}
?>

</body>
</html>
