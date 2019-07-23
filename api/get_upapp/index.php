<?php
    /**
	   * 链接地址：get_upapp  获取app更新
	   *
     * 下面直接来连接操作数据库进而得到json串
     *
     * 按json方式输出通信数据
     *
     * @param unknown $State 状态码
     *
     * @param string $Descriptor  提示信息
     *
	   * @param string $Version  操作时间

     * @param array $Data 返回数据
     *
     * @return string   type  ios  android   版本号：ver
     *
     */
require_once("../../include/config.inc.php");
$Data = array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){
  if($type=="android"){
    $r=$dosql->GetOne("SELECT * FROM upapp  where id=1");
    $versions =$r['version'];
    if($ver == $versions){  //如果版本号相同，则不更新
      $Data=(object)null;
      $State = 0;
      $Descriptor = '此安卓版本暂无更新！';
      $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
                  'Version' => $Version,
                  'Data' => $Data,
                   );
      echo phpver($result);
    }else{
      $State = 1;
      $Descriptor = '此安卓版本有最新版本，请更新！';
      $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
                  'Version' => $Version,
                  'Data' => $r,
                   );
      echo phpver($result);
    }
  }elseif($type=="ios"){
    $r=$dosql->GetOne("SELECT * FROM upapp  where id=2");
    $versions =$r['version'];
    if($ver == $versions){  //如果版本号相同，则不更新
      $Data=object(null);
      $State = 0;
      $Descriptor = '此苹果版本暂无更新！';
      $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
                  'Version' => $Version,
                  'Data' => $Data,
                   );
      echo phpver($result);
    }else{
      $State = 1;
      $Descriptor = '此苹果版本有最新版本，请更新！';
      $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
                  'Version' => $Version,
                  'Data' => $r,
                   );
      echo phpver($result);
    }
  }
}else{
  $State = 520;
  $Descriptor = 'token验证失败！';
  $result = array (
                  'State' => $State,
                  'Descriptor' => $Descriptor,
  				         'Version' => $Version,
                   'Data' => $Data,
                   );
  echo phpver($result);
}

?>
