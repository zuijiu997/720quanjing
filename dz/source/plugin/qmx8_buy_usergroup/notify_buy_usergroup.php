<?php

/*
更多商业插件源码请登录星期六源码xqlzm.com，星期六源码，提供商业插件源码破解，模板定制，插件定制，系统开发
 */

define('IN_API', true);



define('CURSCRIPT', 'api');



require '../../../source/class/class_core.php';



$discuz = C::app();



$discuz->init();



$PHP_SELF = $_SERVER['PHP_SELF'];



$_G['siteurl'] = dhtmlspecialchars('http://'.$_SERVER['HTTP_HOST'].preg_replace("/\/+(source\/plugin\/qmx8_buy_usergroup)?\/*$/i", '', substr($PHP_SELF, 0, strrpos($PHP_SELF, '/'))).'/');

$pay_type = empty($_GET['attach']) || !preg_match('/^[a-z0-9]+$/i', $_GET['attach']) ? 'alipay' : $_GET['attach'];

//安全过滤处理
$pay_type=addslashes($pay_type);

require_once DISCUZ_ROOT."/source/plugin/qmx8_buy_usergroup/".$pay_type."_core.php";



//trade_notifycheck 验证



$notifydata = trade_notifycheck();



//验证通过 说明是支付宝或者财付通返回的安全数据



if($notifydata['validator']) {


	$orderid = $notifydata['order_no'];



	$price = $notifydata['price'];




	$order = DB::fetch_first("SELECT * FROM ".DB::table('qmx8_usergroup')." WHERE orderid='$orderid'");



	if($order && floatval($price) == floatval($order['price']) && ($pay_type == 'tenpay' || strtolower($_G['setting']['ec_account']) == strtolower($_REQUEST['seller_email']))) {



		if($order['status'] == 1) {



			$member=C::t('common_member')->fetch($order['uid'], false, 1);

			if(count($member)==0){

				$tableext = '_inarchive';

			}else{

				$tableext = '';

			}

			DB::query("UPDATE ".DB::table('qmx8_usergroup')." SET status=2,trade_no='$notifydata[trade_no]',confirmdate=$_G[timestamp] WHERE orderid='$orderid'");



			//change groupid



			if($order['validity']==0){



				C::t('common_member'.$tableext)->update($order['uid'], array('groupid'=>$order['gid']));



			}elseif (is_numeric($order['validity']) && $order['validity']>0) {



				$exptimenew=strtotime(date('Y-m-d H:i:s',strtotime("+$order[validity] day")));



				C::t('common_member'.$tableext)->update($order['uid'], array('groupid'=>$order['gid'],'groupexpiry'=>$exptimenew));



				$groupterms['main'] = array('time' => $exptimenew);

				$groupterms['ext'][$order['gid']] = $exptimenew;



				C::t('common_member_field_forum'.$tableext)->update($order['uid'],array('groupterms' => serialize($groupterms)));
			}
			
			if($order['extcredits']!="" && $order['extcredits']!="0"){



				$tmp=explode(',', $order['extcredits']);

				foreach ($tmp as $value) {

					$credit=explode(':', $value);

					updatemembercount($order['uid'], array($credit[1] =>$credit['2']));

				}

			}	

		}

	}







	showmessage('qmx8_buy_usergroup:qmx8_pay_succeed', $_G['siteurl'].'home.php?mod=spacecp&ac=usergroup');



}



else {







	exit($notifydata['notify']);







}























?>