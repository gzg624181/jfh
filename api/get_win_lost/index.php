<?php
    /**
	   * 链接地址：输赢记录  get_win_lost
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
     * @return string
     *

     * 用户会员id  uid  默认开始时间为没一个月的1号，到当天的日期
     *
     * 默认游戏id  gid  默认计算所有的输赢记录
     */
require_once("../../include/config.inc.php");
$Data=array();
$Data1=array();
$Data2=array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){
  $r=$dosql->GetOne("SELECT regtime,ucode FROM `pmw_members` where id= $uid");
  $ucode=$r['ucode'];


  //计算当前的全部的输赢记录  （用户的推荐码，流水总额，下注的期数，盈亏总额） 弄成一条数据
  //下面就是下注的详细的记录 ，包括下注的金额 ，时间，下注流水，期数 ，盈亏数额

  $starttime = empty($starttime) ?  strtotime(date("Y-m-01")) : $starttime;
  $endtime = empty($endtime) ?  strtotime(date("Y-m-d",time()+24*3600)) : $endtime + 24*3600;

  if(isset($gid) && $gid!=""){  //如果gid存在的话
  $two=2;
  $k=$dosql->GetOne("SELECT a.ucode,sum(b.xiazhu_sum) as xiazhu,sum(b.xiazhu_jiangjin) as jiangjin FROM `#@__members` a inner join `#@__xiazhuorder` b on a.id=b.uid  where b.uid=$uid and gameid=$gid and uid=$uid and  b.xiazhu_timestamp >= $starttime and b.xiazhu_timestamp < $endtime");

if(is_array($k)){
   $Data1 = array(
      "ucode" => $k['ucode'],
      "liushui" => $k['xiazhu'],
      "yingkui" => $k['jiangjin'] - $k['xiazhu']    //用户下注的盈亏
   );
}else{
  $Data1 = array(
     "ucode" => $k['ucode'],
     "liushui" => 0.00,
     "yingkui" => 0.00    //用户下注的盈亏
  );
}
  //计算用户的盈亏记录
  $dosql->Execute("SELECT * from pmw_xiazhuorder where gameid=$gid and uid=$uid and  xiazhu_timestamp >= $starttime and xiazhu_timestamp < $endtime order by xiazhu_timestamp desc",$two);
  for($j=0;$j<$dosql->GetTotalRow($two);$j++)
  {
      $show = $dosql->GetArray($two);
      if(is_array($show)){
        $xiazhu =$show['xiazhu_sum'];    //每次下注的金额
        $xiazhu_jiangjin=$show['xiazhu_jiangjin'];  //下注的奖金
        $Data2[$j]['yingkui'] = $xiazhu_jiangjin - $xiazhu;
        $Data2[$j]['xiazhu_qishu'] = $show['xiazhu_qishu'];
        $Data2[$j]['xiazhu_ymd'] = $show['xiazhu_ymd'];
      }else{
        $Data2=array();
      }
  }
}else{
  $two=2;
  $k=$dosql->GetOne("SELECT a.ucode,sum(b.xiazhu_sum) as xiazhu,sum(b.xiazhu_jiangjin) as jiangjin FROM `#@__members` a inner join `#@__xiazhuorder` b on a.id=b.uid  where b.uid=$uid and uid=$uid and  b.xiazhu_timestamp >= $starttime and b.xiazhu_timestamp < $endtime");

  if(is_array($k)){
     $Data1 = array(
        "ucode" => $k['ucode'],
        "liushui" => $k['xiazhu'],
        "yingkui" => $k['jiangjin'] - $k['xiazhu']    //用户下注的盈亏
     );
  }else{
    $Data1 = array(
       "ucode" => $k['ucode'],
       "liushui" => 0.00,
       "yingkui" => 0.00    //用户下注的盈亏
    );
  }

  //计算用户的盈亏记录
  $dosql->Execute("SELECT * from pmw_xiazhuorder where  uid=$uid  and  xiazhu_timestamp >= $starttime and xiazhu_timestamp < $endtime order by xiazhu_timestamp desc",$two);
  for($j=0;$j<$dosql->GetTotalRow($two);$j++)
  {
      $show = $dosql->GetArray($two);
      if(is_array($show)){
        $xiazhu =$show['xiazhu_sum'];    //每次下注的金额
        $xiazhu_jiangjin=$show['xiazhu_jiangjin'];  //下注的奖金
        $Data2[$j]['yingkui'] = $xiazhu_jiangjin - $xiazhu;
        $Data2[$j]['xiazhu_qishu'] = $show['xiazhu_qishu'];
        $Data2[$j]['xiazhu_ymd'] = $show['xiazhu_ymd'];
      }else{
        $Data2=array();
      }
  }
}

   $Data=array(
     "yingkui"=>$Data1,
     "record"=>$Data2
   );
    $State = 1;
    $Descriptor = '盈亏记录查询成功！';
    $result = array (
                'State' => $State,
                'Descriptor' => $Descriptor,
                'Version' => $Version,
                'Data' => $Data,
                 );
    echo phpver($result);


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
