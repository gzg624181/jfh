<?php

require_once("../../include/config.inc.php");
require_once("getcode.php");
$action   = isset($action)   ? $action   : '';
# 手机号码 telephone,code,password,nickname,bcode(选填)
if($action=="reg"){
$Version=date("Y-m-d H:i:s");
$telephone=$phone;
$s=$dosql->GetOne("SELECT id FROM `#@__members` WHERE telephone=$telephone");
if(is_array($s)){
    ShowMsg('此账号已注册！',-1);
}else{
  $r = $dosql->GetOne("SELECT code FROM `#@__yzm` WHERE phone=$telephone");
  $getcode=$r['code'];
  if(is_array($r) && $r['code']==$code){
  $regtime=time();
  $regip=GetIP();
  $password=md5(md5("$password"));
  $ucode=getcode();
  $links=$cfg_weburl."/?code=".$ucode;
  $qrcode=createQr($links);
  $getcity=get_city($regip);
  $devicetype=get_device_type();
  $sql = "INSERT INTO `#@__members` (telephone,password,nickname,ucode,bcode,regtime,regip,qrcode,ymdtime,getcity,links,devicetype) VALUES ('$telephone','$password','$nickname','$ucode','$bcode',$regtime,'$regip','$qrcode','$Version','$getcity','$links','$devicetype')";
  $dosql->ExecNoneQuery($sql);
  //判断bcode是否为空
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

  header("Location: /?success=1");
  exit;
  }else{
 ShowMsg('验证码错误！',-1);
  }
}

}elseif($action =="index_reg"){
$Version=date("Y-m-d H:i:s");
$r = $dosql->GetOne("SELECT code FROM `#@__yzm` WHERE phone=$phone");
$getcode=$r['code'];  //获取发送的手机验证码
if(is_array($r) && $getcode == $sendcode){
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
if($devicetype==0){
header("Location: http://www.baidu.com");
}else{
header("Location: http://www.taobao.com");
}
exit;

}else{
ShowMsg('验证码错误！',-1);
}
 }



 ?>
