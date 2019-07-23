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

else if($action == 'del3'){
  $dosql->QueryNone("DELETE FROM `#@__record` WHERE id=$id");
  $gourl="allorder_sh.php";
  header("location:$gourl");
  exit();
}

//无条件返回
else
{
    header("location:$gourl");
	exit();
}
?>
