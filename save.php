<?php
require_once(dirname(__FILE__).'/include/config.inc.php');
$action = isset($action) ? $action : '';
if($action == 'checkphone')
{
$str = $dosql->GetOne("SELECT * FROM `pmw_members` WHERE telephone='$telephone'");
if(is_array($str)){
  echo  1;
	}else
	{
  echo 0;
	}
}elseif($action=='sendcode'){
   $content=sendcode($cfg_message_id,$cfg_message_pwd,$cfg_message_signid,$cfg_message_regid,$telephone);
   //判断验证码发送成功的时候
   if($content!=0){
   $start_time=date("Y-m-d H:i:s");
   $date=date("Y-m-d");
   $s=$dosql->GetOne("select * from `#@__yzm` where phone='$telephone'");
   if(is_array($s)){
   $r = $dosql->GetOne("SELECT MAX(num) AS `num` FROM `#@__yzm` where phone='$telephone' and date='$date'");
   if(is_array($r)){
   $num = (empty($r['num']) ? 1 : ($r['num'] + 1));
   }else{
   $num=1;
   }
   $sql = "UPDATE `#@__yzm` SET code='$content',start_time='$start_time',num='$num',date='$date' where phone='$telephone'";
   $dosql->ExecNoneQuery($sql);
   }else{
   $sql = "INSERT INTO  `#@__yzm` (phone,code,start_time,num,date) VALUES ('$telephone','$content','$start_time',1,'$date')";
   $dosql->ExecNoneQuery($sql);
   }
   echo $content;
  }else{
   echo 0;
  }
}elseif($action=='forgetpassword_next'){

  $content=forgetpassword_sendcode($cfg_message_id,$cfg_message_pwd,$cfg_message_signid,$cfg_forgetpassword,$telephone);
  //判断验证码发送成功的时候
  if($content!=0){
  $start_time=date("Y-m-d H:i:s");
  $date=date("Y-m-d");
  $s=$dosql->GetOne("select * from `#@__yzm` where phone='$telephone'");
  if(is_array($s)){
  $r = $dosql->GetOne("SELECT MAX(num) AS `num` FROM `#@__yzm` where phone='$telephone' and date='$date'");
  if(is_array($r)){
  $num = (empty($r['num']) ? 1 : ($r['num'] + 1));
  }else{
  $num=1;
  }
  $sql = "UPDATE `#@__yzm` SET code='$content',start_time='$start_time',num='$num',date='$date' where phone='$telephone'";
  $dosql->ExecNoneQuery($sql);
  }else{
  $sql = "INSERT INTO  `#@__yzm` (phone,code,start_time,num,date) VALUES ('$telephone','$content','$start_time',1,'$date')";
  $dosql->ExecNoneQuery($sql);
  }
  echo $content;
  }else{
  echo 0;
  }
}
elseif($action == 'reg'){
  include("api/reg/getcode.php");
  $Version=date("Y-m-d H:i:s");
  $r = $dosql->GetOne("SELECT code FROM `#@__yzm` WHERE phone=$phone");
  $getcode=$r['code'];  //获取发送的手机验证码
  if(is_array($r) && $getcode==$sendcode){
  $regtime=time();
  $regip=GetIP();
  $password=md5(md5("$password"));
  $ucode=getcode();   //自动生成个人推荐码
  $links=$cfg_beiyong."/?code=".$ucode;
  $qrcode=createQr($links);
  $getcity=get_city($regip);
  $devicetype=get_device_type();
  $sql = "INSERT INTO `#@__members` (telephone,password,nickname,ucode,bcode,regtime,regip,qrcode,ymdtime,getcity,links,devicetype) VALUES ('$phone','$password','$nickname','$ucode','$bcode',$regtime,'$regip','$qrcode','$Version','$getcity','$links','$devicetype')";
  $dosql->ExecNoneQuery($sql);
  //判断bcode是否为空，如果推荐码不为空，则说明是通过推荐码注册过来的
  if($bcode!=""){

     //判断当前注册的推荐人是否有推荐人
      $s=$dosql->GetOne("SELECT bcode,telephone,nickname FROM `#@__members` where ucode=$bcode");
      $bbcode=$s['bcode']; //推荐人的推荐人
      if($bbcode!=""){
      $k=$dosql->GetOne("SELECT telephone,nickname,id FROM `#@__members` where ucode=$bbcode");
      //如果推荐人的推荐人不为空，则给推荐人添加二级代理
      $jointime=time();
      $telephone=$k['telephone'];
      $nickname=$k['nickname'];
      $uid=$k['id'];
      $sql = "INSERT INTO `#@__daili` (uid,telephone,nickname,ucode,zscode,ejcode,jointime) VALUES ($uid,'$telephone','$nickname',$bbcode,$bcode,$ucode,$jointime)";
      $dosql->ExecNoneQuery($sql);
      }
  }

  $url = $cfg_download;
  header("location:$url");
  exit();

  }else{
  ShowMsg('验证码错误！','index.php');
  }

}elseif($action=="forgetpassword"){
   $s=$dosql->GetOne("select id from `#@__members` where telephone='$mobile'");
   if(is_array($s)){
    $id=$s['id'];
    $gourls = "forgetpassword_next.php?id=".$id;
    header("location:$gourls");
		exit();
   }else{
    ShowMsg('暂无此账号，请重新注册！',-1);
   }

}elseif($action=="getup"){
  $password=md5(md5("$password"));
  $sql = "UPDATE `#@__members` SET password='$password' where telephone='$phone'";
  $dosql->ExecNoneQuery($sql);
  header('Location: /?changepassword=1');
  exit;
}

?>
