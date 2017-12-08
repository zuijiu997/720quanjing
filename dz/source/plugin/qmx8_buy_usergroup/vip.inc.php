<?php
/*
更多商业插件源码请登录星期六源码xqlzm.com，星期六源码，提供商业插件源码破解，模板定制，插件定制，系统开发
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if(!$_G['uid']) {
	showmessage('not_loggedin', NULL, array(), array('login' => 1));
}

if($_GET['buysubmit']){
	//id

	$bid=$_GET['bid'];

	//支付方式
	$pay_type = is_numeric($_GET['type_id']) ? 'tenpay' : $_GET['type_id'];
	require_once DISCUZ_ROOT.'/source/plugin/qmx8_buy_usergroup/'.$pay_type.'_core.php';

	//从配置文件中加载信息

	list($price,$gid,$gname,$date,$cid_count)=get_buy_info($bid);
	
	//构建支付链接
	$requesturl = credit_payurl($price, $gname);
	
	DB::query("INSERT INTO ".DB::table('qmx8_usergroup')." (`orderid` ,`status` ,`uid` ,`trade_no` ,`gid` ,`gname` ,`extcredits` ,`price` ,`validity` ,`submitdate` ,`confirmdate` ,`ip`,`pay_type`) VALUES ('$orderid', '1', '$_G[uid]', '', '$gid', '$gname', '$cid_count', '".floatval($price)."', '$date', '$_G[timestamp]', '', '$_G[clientip]','$pay_type')");
	//跳转到支付页面

	include template('common/header_ajax');
	echo '<form id="payform" action="'.$requesturl.'" method="post"></form><script type="text/javascript" reload="1">$(\'payform\').submit();</script>';
	include template('common/footer_ajax');
	header("Location:$requesturl");

}
if($_GET['select_pay_type']){
	$bid=$_GET['bid'];
	$select_pay="plugin.php?id=qmx8_buy_usergroup:vip&buysubmit=true&bid=$bid&type_id=";
	include template('common/header_ajax');
	include template('qmx8_buy_usergroup:pay_type');
	include template('common/footer_ajax');
}


//TODO - Insert your code here

//加载配置项
$var=$_G['cache']['plugin']['qmx8_buy_usergroup'];

//论坛标题
$navtitle = str_replace('{bbname}', $_G['setting']['bbname'], $_G['setting']['seotitle']['forum']);

//购买规则
$c_rule=$var['c_rule'];

$tmp_list=explode("\r\n",$c_rule);
$glist=array();
foreach ($tmp_list as $row) {
	$l=explode("||", $row);
	if(substr($row,0,1)=="#" || count($l)!=5){
		continue;
	}else{
		if($l[4]!="" && $l!=0){
			$t=str_replace('，', ',', $l[4]);
			$t=str_replace('：', ':', $t);
			$t=explode(",", $t);
			$ll=array();
			foreach ($t as $tt) {
				$t2=explode(":", $tt);
				if(count($t2)==3){
					array_push($ll, $t2);
				}
			}
		}
		$l[4]=$ll;
		array_push($glist, $l);
	}
}

//特权说明
$ttlist=getlist($var['t_rule']);
$otlist=getlist($var['other_tip']);

include template('qmx8_buy_usergroup:vip');


function get_buy_info($bid)

{

	//获取购买用户组相关数据

	//一级精灵||10||10||0||金钱:extcredits1:500,贡献:extcredits2:500
	global $_G;
	$var=$_G['cache']['plugin']['qmx8_buy_usergroup'];
	$glists=explode("\r\n", $var['c_rule']);
	$cid_count="";
	$i=0;
	foreach ($glists as $glist) {		
		$gl=explode("||", $glist);
		if(substr($glist,0,1)=="#" || count($gl)!=5){
			continue;
		}else{
			$i++;
			if($i==$bid){

			$gid=$gl[1];

			$price=$gl[2];

			$gname=$gl[0];

			$date=$gl[3];

			if($gl[4]!="0"){

				//金钱:extcredits1:500,贡献:extcredits2:500

				$cid_count=$gl[4];

			    $cid_count=str_replace('：', ':', $cid_count);

    			$cid_count=str_replace('，', ',', $cid_count);			

			}
			break;
			}

		}	
	}

	return array($price,$gid,$gname,$date,$cid_count);

}


function getlist($arg)
{
	$t_rule=$arg;
	$tl=explode("\r\n",$t_rule);
	$tlist=array();
	foreach ($tl as $row) {
		$l2=explode("||", $row);
		if(substr($row,0,1)=="#" || count($l2)<=1){
			continue;
		}else{
			array_push($tlist, $l2);
		}	
	}
	$tlist2=array();
	$tt="";
	$ttlist=array();
	while (count($tlist)>0) {
		if($tt==""){
			$tt=$tlist[0][0];
			array_push($tlist2, $tlist[0]);

		}else{

			if($tt==$tlist[0][0]){
				array_push($tlist2, $tlist[0]);
			}else{
				array_push($ttlist,$tlist2);
				$tlist2=array();
				$tt=$tlist[0][0];
				array_push($tlist2, $tlist[0]);
			}

		}
		array_splice($tlist,0,1); 	
	}
	array_push($ttlist,$tlist2);	
	return $ttlist;
}

?>