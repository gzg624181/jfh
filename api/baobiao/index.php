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
     * 推荐受益
     * 业务收益
     * 实际业绩
     * 下线数量
     * 投注金额
     * 中奖金额
     * 投注提成
     * 下线返水
     * 活动金额
     * 二级下线数量
     * 二级投注金额
     */
require_once("../../include/config.inc.php");
$Data=array();
$Data1=array();
$Data2=array();
$Version=date("Y-m-d H:i:s");
if(isset($token) && $token==$cfg_auth_key){
  $r=$dosql->GetOne("SELECT regtime,ucode FROM `pmw_members` where id= $uid");
  $ucode=$r['ucode'];


  //默认从每个月的第一天开始
  $starttime = empty($starttime) ?  strtotime(date("Y-m-01")) : $starttime;
  $endtime = empty($endtime) ?  strtotime(date("Y-m-d",time()+24*3600)) : $endtime + 24*3600;


  //业务收益  （广告位+主推收益=业务收益）
 $yewu_money = "0.00";

 //实际业绩
 $shiji_money = "0.00";

 //下线数量(所有的一级下线的数量+所有的二级下线的数量)

 $xiaxian_num=get_yiji($uid);

 //投注金额

 $touzhu_money=sprintf("%.2f",get_xiazhusum($starttime,$endtime,$uid));

 //中奖金额

 $zhongjiang_money=sprintf("%.2f",get_zhongjiangsum($starttime,$endtime,$uid));

 //投注提成

 $ticheng_money=sprintf("%.2f",get_touzhu_ticheng($starttime,$endtime,$uid));;

 //下线返水

 $fannshui="0.00";

 //活动金额

 $active_money="0.00";

 //二级下线数量
 $erji_xiaxian=get_erji_nums($uid);

 //二级投注金额
 $erji_touzhu=erji_touzhu($uid);

 //二级投注提成
$erji_ticheng="0.00";

   $Data=array(
     "starttime"=>date("Y-m-d",$starttime),
     "endtime"=>date("Y-m-d",$endtime-24*3600),
     "yewu"=>$yewu_money,
     "shiji"=>$shiji_money,
     "xiaxia"=>strval($xiaxian_num),
     "touzhu"=>$touzhu_money,
     "zhongjiang"=>$zhongjiang_money,
     "ticheng"=>$ticheng_money,
     "fannshui"=>$fannshui,
     "active"=>$active_money,
     "erjixiaxian"=>strval($erji_xiaxian),
     "erjitouzhu"=>strval($erji_touzhu),
     "erjiticheng"=>$erji_ticheng
   );

    $State = 1;
    $Descriptor = '报表数据统计成功！';
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
