<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');

/*
**************************
(C)2010-2017 phpMyWind.com
update: 2014-5-30 17:22:45
person: Feng
**************************
*/


//初始化参数
$tbname = 'pmw_bank';
$gourl  = 'way.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');



//添加充值列表
if($action == 'add')
{

    $addtime=time();

    $sql = "INSERT INTO `$tbname` (typename, types, addtime) VALUES ('$typename', '$types', $addtime)";

		if($dosql->ExecNoneQuery($sql))
		{
			header("location:$gourl");
			exit();
		}
}


//修改充值简介
else if($action == 'update'){
  $addtime=time();

	$sql = "UPDATE `$tbname` SET typename='$typename',types='$types' WHERE id=$id";


	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}

}

//删除游戏列表介绍
else if($action == 'del6'){
	$sql = "delete  from `$tbname` where id=$id";
	$dosql->ExecNoneQuery($sql);
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
