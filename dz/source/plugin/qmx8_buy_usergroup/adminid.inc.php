<?php
/*
更多商业插件源码请登录星期六源码xqlzm.com，星期六源码，提供商业插件源码破解，模板定制，插件定制，系统开发
 */


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {



	exit('Access Denied');



}



$orderurl = array(

	'alipay' => 'https://www.alipay.com/trade/query_trade_detail.htm?trade_no=',

	'tenpay' => 'https://www.tenpay.com/med/tradeDetail.shtml?trans_id=',

);



if(!submitcheck('ordersubmit')) {



		echo '<script type="text/javascript" src="static/js/calendar.js"></script>';



		showtips(lang('plugin/qmx8_buy_usergroup', 'qmx8_orders_tips'));



		showtagheader('div', 'ordersearch', !submitcheck('searchsubmit', 1));



		showformheader('plugins&identifier=qmx8_buy_usergroup&pmod=adminid');



		showtableheader(lang('plugin/qmx8_buy_usergroup', 'qmx8_orders_search'));



		showsetting(lang('plugin/qmx8_buy_usergroup', 'qmx8_orders_buyer'), array('orderstatus', array(



			array('',lang('plugin/qmx8_buy_usergroup', 'qmx8_orders_search_status_all')),



			array(1, lang('plugin/qmx8_buy_usergroup', 'qmx8_orders_search_status_pending')),



			array(2, lang('plugin/qmx8_buy_usergroup', 'qmx8_orders_search_status_auto_finished')),



		)), intval($orderstatus), 'select');



		showsetting(lang('plugin/qmx8_buy_usergroup', 'qmx8_orders_buyer'), 'users', $users, 'text');



		showsetting(lang('plugin/qmx8_buy_usergroup', 'qmx8_orders_search_submit_date'), array('sstarttime', 'sendtime'), array($sstarttime, $sendtime), 'daterange');



		showsetting(lang('plugin/qmx8_buy_usergroup', 'qmx8_orders_search_confirm_date'), array('cstarttime', 'cendtime'), array($cstarttime, $cendtime), 'daterange');



		showsubmit('searchsubmit');



		showtablefooter();



		showformfooter();



		showtagfooter('div');







		if(submitcheck('searchsubmit', 1)) {







			$start_limit = ($page - 1) * $_G['tpp'];



			$ordercount = count_by_search($_GET['orderstatus'], ($_GET['users'] ? explode(',', str_replace(' ', '', $_GET['users'])) : null),strtotime($_GET['sstarttime']), strtotime($_GET['sendtime']), strtotime($_GET['cstarttime']), strtotime($_GET['cendtime']));



			$multipage = multi($ordercount, $_G['tpp'], $page, ADMINSCRIPT."?action=plugins&identifier=qmx8_buy_usergroup&pmod=adminid&searchsubmit=yes&orderstatus={$_GET['orderstatus']}&orderid={$_GET['orderid']}&users={$_GET['users']}&buyer={$_GET['buyer']}&admin={$_GET['admin']}&sstarttime={$_GET['sstarttime']}&sendtime={$_GET['sendtime']}&cstarttime={$_GET['cstarttime']}&cendtime={$_GET['cendtime']}");



			showtagheader('div', 'orderlist', TRUE);



			showformheader('plugins&identifier=qmx8_buy_usergroup&pmod=adminid');



			showtableheader(lang('plugin/qmx8_buy_usergroup', 'qmx8_search_result'));



			showsubtitle(array('',lang('plugin/qmx8_buy_usergroup', 'qmx8_orders_id'), lang('plugin/qmx8_buy_usergroup', 'qmx8_order_status'), lang('plugin/qmx8_buy_usergroup', 'qmx8_orders_buyer'), lang('plugin/qmx8_buy_usergroup', 'qmx8_buy_groupname'), lang('plugin/qmx8_buy_usergroup', 'qmx8_expiration'),lang('plugin/qmx8_buy_usergroup', 'qmx8_orders_price'),lang('plugin/qmx8_buy_usergroup', 'qmx8_orders_submitdate'),lang('plugin/qmx8_buy_usergroup', 'qmx8_orders_confirmdate')));









			//查询

			foreach(fetch_all_by_search( $_GET['orderstatus'],($_GET['users'] ? explode(',', str_replace(' ', '', $_GET['users'])) : null),strtotime($_GET['sstarttime']), strtotime($_GET['sendtime']), strtotime($_GET['cstarttime']), strtotime($_GET['cendtime']),$start_limit, $_G['tpp']) as $order) {



				switch($order['status']) {



					case 1: $order['orderstatus'] =lang('plugin/qmx8_buy_usergroup', 'qmx8_orders_search_status_pending'); break;



					case 2: $order['orderstatus'] =lang('plugin/qmx8_buy_usergroup', 'qmx8_orders_search_status_auto_finished'); break;



				}



				$order['submitdate'] = dgmdate($order['submitdate']);



				$order['confirmdate'] = $order['confirmdate'] ? dgmdate($order['confirmdate']) : 'N/A';



				$orderid=$order['trade_no'];



				$pay_type=$order['pay_type'];



				$validity=$order['validity'];



				if($validity=="0"){



					$validity=lang('plugin/qmx8_buy_usergroup', 'qmx8_forever');



				}else{



					$validity=$validity.lang('plugin/qmx8_buy_usergroup', 'qmx8_day');



				}







				$orderid = '<a href="'.$orderurl[$pay_type].$orderid.'" target="_blank">'.$orderid.'</a>';



				showtablerow('', '', array(



					"<input class=\"checkbox\" type=\"checkbox\" name=\"validate[]\" value=\"$order[orderid]\" ".($order['status'] != 1 ? 'disabled' : '').">",



					"$order[orderid]<br />$orderid",



					$order[orderstatus],



					"<a href=\"home.php?mod=space&uid=$order[uid]\" target=\"_blank\">$order[username]</a>",



					"$order[gname]",$validity,



					lang('plugin/qmx8_buy_usergroup', 'qmx8_rmb')." ".$order[price]." ".lang('plugin/qmx8_buy_usergroup', 'qmx8_yuan'),



					$order[submitdate],



					$order[confirmdate]



				));



			}

			showsubmit('', '', '', '<a href="#" onclick="$(\'orderlist\').style.display=\'none\';$(\'ordersearch\').style.display=\'\';">'.cplang('research').'</a>', $multipage);

			showtablefooter();



			showformfooter();



			showtagfooter('div');



		}







	}



function fetch_all_by_search($status = null,$username = null, $submit_starttime = null, $submit_endtime = null, $confirm_starttime = null, $confirm_endtime = null,$start = null, $limit = null) {



		$sql = '';



		$sql .= $status ? ' AND o.'.DB::field('status', $status) : '';



		$sql .= $username ? ' AND m.'.DB::field('username', $username) : '';



		$sql .= $submit_starttime ? ' AND o.'.DB::field('submitdate', $submit_starttime, '>=') : '';



		$sql .= $submit_endtime ? ' AND o.'.DB::field('submitdate', $submit_endtime, '<') : '';



		$sql .= $confirm_starttime ? ' AND o.'.DB::field('confirmdate', $confirm_starttime, '>=') : '';



		$sql .= $confirm_endtime ? ' AND o.'.DB::field('confirmdate', $confirm_endtime, '<') : '';



		return DB::fetch_all('SELECT o.*'.(($uid !== 0) ? ', m.username' : '').' FROM '.DB::table('qmx8_usergroup').' o'.(($uid !== 0) ? ', '.DB::table('common_member').' m WHERE o.uid=m.uid' : ' WHERE 1 ').' %i ORDER BY o.submitdate DESC '.DB::limit($start, $limit), array($sql));



}

function count_by_search($status = null, $username = null,$submit_starttime = null, $submit_endtime = null, $confirm_starttime = null, $confirm_endtime = null) {



		$sql = '';



		$sql .= $status ? ' AND o.'.DB::field('status', $status) : '';



		$sql .= $username ? ' AND m.'.DB::field('username', $username) : '';



		$sql .= $submit_starttime ? ' AND o.'.DB::field('submitdate', $submit_starttime, '>=') : '';



		$sql .= $submit_endtime ? ' AND o.'.DB::field('submitdate', $submit_endtime, '<') : '';



		$sql .= $confirm_starttime ? ' AND o.'.DB::field('confirmdate', $confirm_starttime, '>=') : '';



		$sql .= $confirm_endtime ? ' AND o.'.DB::field('confirmdate', $confirm_endtime, '<') : '';



		return DB::result_first('SELECT COUNT(*) FROM '.DB::table('qmx8_usergroup').' o'.(($uid !== 0) ? ', '.DB::table('common_member').' m WHERE o.uid=m.uid' : ' WHERE 1 ').' %i', array($sql));



}

?>