<?php
    /**
	   * 链接地址：消息 getmessage 接口
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
     *  params: uid, 用户id
     *          gameid, 游戏id
     *          gamename, 游戏名称
     *          timestamp 当前时间
     *          mid: 聊天记录id， 为空时返回当前时间timestamp往前的20条消息
     *
     */
     header('Content-Type: application/json; charset=utf-8');
     require_once("../../include/config.inc.php");
     date_default_timezone_set('Asia/Shanghai');

     if(isset($move)){
     if($move==""){
       $move="next";
     }elseif($move=="next"){
       $move="next";
     }elseif($move=="up"){
       $move="up";
     }else{
       $move="next";
     }
     }else{
       $move="next";
     }



     $Data = array();
     $Version=date("Y-m-d H:i:s");
     if(isset($token) && $token==$cfg_auth_key){

       $now=time();
       $Data=array();
       $one=1;
       $k=$dosql->GetOne("SELECT money,nickname FROM pmw_members WHERE  id = $uid");
       if(is_array($k)){
       $money = sprintf("%.2f",$k['money']);
       }else{
       $money =0;
       }

       $url=$cfg_get_kjstate;

       $arr=https_request($url);

       $array=json_decode($arr,true);

       $kj_times=$array['data']['current_num'];  //获取当前的期数

       $state=$array['data']['current_state'];   //当前开奖的状态    -1系统错误   0下注中  1封盘  2开奖中

       $dosql->Execute("SELECT id from pmw_xiazhucontent  where  userid =$uid  and xiazhu_times='$kj_times' and  gameid=$gameid",$one);
       $num=$dosql->GetTotalRow($one);

       $r=$dosql->GetOne("SELECT kj_endtime_sjc,kj_times,kj_endtime,id,kj_times,state from pmw_lotterynumber where kj_times='$kj_times'");

       $kj_endtime_sjc = $r['kj_endtime_sjc'];
       $kj_endtime = $r['kj_endtime'];
       $kj_times= $r['kj_times'];

       //通过聊天消息记录id


       $r= $dosql->GetOne("SELECT id FROM pmw_message where gid=$gameid  order by id desc limit 1");
       $current_id = $r['id'];

  if($state==1 || $state==2){
      $Data['current']['process'] = 2;    //封盘开奖中
      $Data['current']['countdown'] =30;
      $Data['current']['kjtime'] = intval($kj_endtime_sjc);   //开奖时间
      $Data['current']['fptime'] = 0;
      $Data['current']['serial'] = strval($kj_times);
      $Data['current']['people'] = rand(100,1000);
      $Data['current']['money'] =   strval($money);
      $Data['current']['money_double'] =floatval($money);
      $Data['current']['num'] =intval($num);
      $Data['current']['curret_id']= $current_id;
  }elseif($state==0){
      $ahead_kjtimes=$kj_times-1;

      $s=$dosql->GetOne("SELECT kj_endtime_sjc from pmw_lotterynumber where kj_times=$ahead_kjtimes");
      $countdown = $s['kj_endtime_sjc'] + 180 -$now;
      $Data['current']['process'] = 1;   //倒计时下注时间
      $Data['current']['countdown'] = $countdown;
      $Data['current']['kjtime'] = intval($kj_endtime_sjc);   //下次开奖时间，封盘中则为空
      $Data['current']['fptime'] = intval($kj_endtime_sjc+180) ;
      $Data['current']['serial'] = strval($kj_times);
      $Data['current']['people'] = rand(100,1000);
      $Data['current']['money'] =  strval($money);
      $Data['current']['money_double'] = floatval($money);
      $Data['current']['num'] =intval($num);
      $Data['current']['curret_id']= $current_id;
  }

  $one=1;
  $two=2;
  $dosql->Execute("SELECT kj_times as serial, kj_mdhi as time, kj_varchar as value from pmw_lotterynumber  where  kj_state =1  and state='kj'  and kj_times <> '' and kj_varchar <> '' order by id desc limit 0,10",$two);
  for($i=0;$i<$dosql->GetTotalRow($two);$i++)
  {
      $row = $dosql->GetArray($two);
      $Data['current']['history'][$i]=$row;
  }


   //通过对当前最后一条的数据进行判断，如果最后一条数据和窜过来的id相等，则为空


   if($move="next"){

   if(isset($mid)){
   if($mid!=""){
   if($current_id > $mid){
   $dosql->Execute("SELECT * FROM `pmw_message` where gid=$gameid and id > $mid order by id desc",$one);
   $num=$dosql->GetTotalRow($one);

   for($i=0;$i<$dosql->GetTotalRow($one);$i++)
   {
       $row1 = $dosql->GetArray($one);
       $Data['message'][$i]=$row1;
       $Data['message'][$i]['content']=json_decode($row1['content'],true);
   }

   $message=array();
   $message=array_reverse($Data['message']);
   }else{
   $message=array();
   }
   $Data['current']['next_id']= $mid-40;
   }else{
     $dosql->Execute("SELECT * FROM `pmw_message` where gid=$gameid order by id desc limit 0,20",$one);
     $num=$dosql->GetTotalRow($one);
     if($num>0){
     for($i=0;$i<$dosql->GetTotalRow($one);$i++)
     {
         $row1 = $dosql->GetArray($one);
         $Data['message'][$i]=$row1;
         $Data['message'][$i]['content']=json_decode($row1['content'],true);
     }
     $message=array();
     $message=array_reverse($Data['message']);
     }
     $Data['current']['next_id']= $current_id-40;
   }
 }else{
   $dosql->Execute("SELECT * FROM `pmw_message` where gid=$gameid order by id desc limit 0,20",$one);
   $num=$dosql->GetTotalRow($one);
   if($num>0){
   for($i=0;$i<$dosql->GetTotalRow($one);$i++)
   {
       $row1 = $dosql->GetArray($one);
       $Data['message'][$i]=$row1;
       $Data['message'][$i]['content']=json_decode($row1['content'],true);
   }
   $message=array();
   $message=array_reverse($Data['message']);
   }
   $Data['current']['next_id']= $current_id-40;
 }
}elseif($move='up'){  //往上翻
  if(isset($mid)){
    //往前翻40条数据
    if($mid!=""){
    $dosql->Execute("SELECT * FROM `pmw_message` where gid=$gameid and id < $mid- 40 order by id desc",$one);
    $num=$dosql->GetTotalRow($one);

    for($i=0;$i<$dosql->GetTotalRow($one);$i++)
    {
        $row1 = $dosql->GetArray($one);
        $Data['message'][$i]=$row1;
        $Data['message'][$i]['content']=json_decode($row1['content'],true);
    }

    $message=array();
    $message=array_reverse($Data['message']);
    $Data['current']['next_id']= $mid-40;
  }else{
    $dosql->Execute("SELECT * FROM `pmw_message` where gid=$gameid and id < $current_id - 40 order by id desc limit 0,20",$one);
    $num=$dosql->GetTotalRow($one);
    if($num>0){
    for($i=0;$i<$dosql->GetTotalRow($one);$i++)
    {
        $row1 = $dosql->GetArray($one);
        $Data['message'][$i]=$row1;
        $Data['message'][$i]['content']=json_decode($row1['content'],true);
    }
    $message=array();
    $message=array_reverse($Data['message']);
    }
    $Data['current']['next_id']= $current_id-40;
  }

  }else{
    $dosql->Execute("SELECT * FROM `pmw_message` where gid=$gameid and id < $current_id - 40 order by id desc limit 0,20",$one);
    $num=$dosql->GetTotalRow($one);
    if($num>0){
    for($i=0;$i<$dosql->GetTotalRow($one);$i++)
    {
        $row1 = $dosql->GetArray($one);
        $Data['message'][$i]=$row1;
        $Data['message'][$i]['content']=json_decode($row1['content'],true);
    }
    $message=array();
    $message=array_reverse($Data['message']);
    }
    $Data['current']['next_id']= $current_id-40;
  }
}



   $Data['message']=$message;
    $State = 1;
    $Descriptor = '数据获取成功！';
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
