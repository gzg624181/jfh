<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('member');

/*
**************************
(C)2010-2015 phpMyWind.com
update: 2014-5-30 17:16:14
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__members';
$tbnames = '#@__charge';
$gourl  = 'member.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');

//修改会员信息
if($action == 'update')
{
  $regtime=strtotime($ymdtime);
  $imagesurl="templates/default/images/avatar/".$images.".jpg";
	$sql = "UPDATE `$tbname` SET getname='$getname', nickname='$nickname',images = '$images', imagesurl='$imagesurl', qq='$qq', regtime=$regtime, ymdtime='$ymdtime', money='$money' WHERE id=$id";
	if($dosql->ExecNoneQuery($sql))
	{

		header("location:$gourl");
		exit();
	}
}


//后台充值
else if($action == 'charge')
{
  $chargegive=$cfg_chargegive;  //充值赠送
  $randnumber=rand(100000,999999);
  $chargeorder=date("YmdHis").$randnumber;
  $charge_ymd=substr($chargetime,0,10);
  $sql = "INSERT INTO `$tbnames` (mid, chargeuid, chargenumber, chargegive, chargetime, chargetype, chargetelephone,randnumber,chargeorder,charge_ymd) VALUES ($mid, $ucode, '$money', '$chargegive', '$chargetime' , $chargetype, '$telephone',$randnumber,'$chargeorder','$charge_ymd')";
  $addmoney=$money + $chargegive;
  if($dosql->ExecNoneQuery($sql))
  {
    $dosql->ExecNoneQuery("UPDATE `$tbname` SET `money`=`money` + '$addmoney' WHERE `id`= $mid");
    $gourl="success.php?randnumber=".$randnumber;
    records($money,"recharge",$mid,$chargeorder);
    header("location:$gourl");
    exit();
  }
}

//后台减分
elseif($action=="reduce"){
  if($reducemoney > $money){
    ShowMsg("减去分数不能大于账号余额！",-1);
  }else{
    //将账户的余额减去要减掉的分数
    $dosql->ExecNoneQuery("UPDATE pmw_members set `money`=`money` - $reducemoney where id=$mid");

    //将此条记录保存下来
    $dosql->ExecNoneQuery("INSERT INTO pmw_reducemoney (mid,ucode,telephone,lastmoney,reducemoney,reducetime) values ($mid,$ucode,'$telephone','$money','$reducemoney','$reducetime')");
    ShowMsg("减分成功！",$gourl);
    exit();
  }

}

//查询玩家具体信息

elseif($action=="search"){





}
else if($action == 'del3'){
  $dosql->QueryNone("DELETE FROM `#@__record` WHERE id=$id");
  $gourl="allorder_sh.php";
  header("location:$gourl");
  exit();

}elseif($action =="quick_scroing"){

  if(is_numeric($keyword)){
    $r=$dosql->GetOne("SELECT id FROM `#@__members` where telephone='$keyword' or ucode=$keyword");
    if(is_array($r)){
    $id = $r['id'];
    if($type=="search"){
    $gourl= "member_content.php?id=".$id."&type=".$type;
    }else{
    $gourl= "quick_scroing_content.php?id=".$id."&type=".$type;
    }
    header("location:$gourl");
    }else{
      ShowMsg("搜索用户账号或推荐码关键字暂未查到会员信息，请重新输入!",-1);
    }
  }else{
    $r=$dosql->GetOne("SELECT id FROM `#@__members` where nickname='$keyword'");
    if(is_array($r)){
    $id = $r['id'];
    if($type=="search"){
    $gourl= "member_content.php?id=".$id."&type=".$type;
    }else{
    $gourl= "quick_scroing_content.php?id=".$id."&type=".$type;
    }
    header("location:$gourl");
    }else{
      ShowMsg("搜索用户昵称关键字暂未查到会员信息，请重新输入!",-1);
    }
      ShowMsg("请输入用户账号或者推荐码或昵称进行查询!",-1);

  }

}elseif($action == "huishui"){
  //将回水的记录保存下来，同时向用户的账号里面增加回水的金额，向账户明细里面保存记录
  //1.向用户的账号里面添加回水的金额
  $dosql->ExecNoneQuery("UPDATE pmw_members set money = money + $money where id=$uid");

  //2.保存数据明细
  $dosql->ExecNoneQuery("INSERT INTO pmw_huishui (telephone,gameid,gametypes,money,addtime,uid,adminname,adminlevel,tj_time,yingkui_money) values ('$telephone',$gameid,'$gametypes','$money','$addtime',$uid,'$admin',$adminlevel,'$tj_time','$yingkui_money')");

  //3.向账户明细里面添加保存记录
  $randnumber=rand(100000,999999);
  $chargeorder=date("YmdHis").$randnumber;
  $time_list = time();
  $dosql->ExecNoneQuery("INSERT INTO pmw_record (gid,money_list,types,mid,time_list,chargeorder) values ($gameid,'$money','fanshui',$uid,$time_list,'$chargeorder')");
  ShowMsg("反水金额添加成功！",-1);
}

//无条件返回
else
{
    header("location:$gourl");
	exit();
}
?>
