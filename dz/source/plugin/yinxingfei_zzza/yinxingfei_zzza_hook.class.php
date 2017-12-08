<?php
/**
 *      本程序由尹兴飞开发
 *      若要二次开发或用于商业用途的，需要经过尹兴飞同意。
 *
 *		http://app.yinxingfei.com			插件技术支持
 *
 *		http://www.cglnn.com			    插件演示站点
 *
 ->		==========================================================================================
 *
 *      2014-11-01 开始由6.1升级到6.2！
 *
 *		愿我的同学、家人、朋友身体安康，天天快乐！
 ->		同时也祝您使用愉快！
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_yinxingfei_zzza {
	
	function global_usernav_extra3() {
		global $_G;
		$set = $_G['cache']['plugin']['yinxingfei_zzza'];
		$zzza_link = $set['zzza_link'];
		$dbwzys = $set['zzza_dbwzys'];
		$dbwznr = $set['zzza_dbwznr'];
		
		$dbwz = $set['zzza_dbwz'];
		if($dbwz == 3){
			include template('yinxingfei_zzza:yinxingfei_zzza_rili_nav');
			return $return;
		}
		
	}
	function global_usernav_extra2() {
		global $_G;
		$set = $_G['cache']['plugin']['yinxingfei_zzza'];
		$zzza_link = $set['zzza_link'];
		$dbwzys = $set['zzza_dbwzys'];
		$dbwznr = $set['zzza_dbwznr'];
		$dbwz = $set['zzza_dbwz'];
		
		if($dbwz == 2){
			include template('yinxingfei_zzza:yinxingfei_zzza_rili_nav');
			return $return;
		}
		
	}
	function global_usernav_extra1() {
		global $_G;
		$set = $_G['cache']['plugin']['yinxingfei_zzza'];
		$zzza_link = $set['zzza_link'];
		$dbwzys = $set['zzza_dbwzys'];
		$dbwznr = $set['zzza_dbwznr'];
		$dbwz = $set['zzza_dbwz'];
		
		if($dbwz == 1){
			include template('yinxingfei_zzza:yinxingfei_zzza_rili_nav');
			return $return;
		}
		
	}
	function global_usernav_extra4() {
		global $_G;
		$set = $_G['cache']['plugin']['yinxingfei_zzza'];
		$zzza_link = $set['zzza_link'];
		$dbwzys = $set['zzza_dbwzys'];
		$dbwznr = $set['zzza_dbwznr'];
		$dbwz = $set['zzza_dbwz'];
		
		if($dbwz == 4){
			include template('yinxingfei_zzza:yinxingfei_zzza_rili_nav');
			return $return;
		}
	}
	
	function global_footer() {
		global $_G;
		if($_G['uid']){
				$set = $_G['cache']['plugin']['yinxingfei_zzza'];
				$zzza_group = unserialize($set['zzza_group']);
				$zzza_group = array_filter($zzza_group);
			if(!in_array($_G['groupid'], $zzza_group)){
				$no_group = '1';
			}else{
				$ftyj = $set['zzza_ftyj'];
				$zzza_lx = $set['zzza_lx'];
				$norw = unserialize($set['zzza_norw']);
				$zzza_bankuai = unserialize($set['zzza_bankuai']);
				$zzza_bankuai = array_filter($zzza_bankuai);
				$norw = array_filter($norw);
				$zzza_bankuair = implode(",",$zzza_bankuai);
				$zzza_bankuair = empty($zzza_bankuair) ? 0 : $zzza_bankuair;
				$cdb_pper['zzza_uid'] = intval($_G['uid']);//获取当前用户UID
				$querya = DB::fetch_first("SELECT * FROM ".DB::table("yinxingfei_zzza_rank")." WHERE zzza_uid = '{$cdb_pper['zzza_uid']}'");
				//用户数据处理
				$jf = DB::fetch_first("SELECT * FROM ".DB::table('yinxingfei_zzza_rank')." WHERE zzza_uid = '$_G[uid]'");
				$zzza_count = $jf['cj_cs'];//用户摇奖次数
				$jf['zzza_lasttime'] = empty($jf['zzza_lasttime'])? 0 : $jf['zzza_lasttime'];
				$zzza_istime = $jf['zzza_lasttime'];//用户上次摇奖时间
				//判断用户今天是否参与过摇奖
				if(dgmdate($_G['timestamp'],'Ymd',$_G['setting']['timeoffset']) == $jf['zzza_lasttime']){
					$zzza_time = 1;//标记今天已经摇奖
				}else{
					$zzza_time = 0;//标记今天还没摇奖
				}
				if ($zzza_time == 0){
				//每日的摇奖任务统计
				$tdateline = strtotime(date('Y-m-d',time()));
					if(!in_array($_G['groupid'], $norw) && $ftyj != '0'){//判断是否为需要做任务的用户组
						//统计今天的发帖和回复数量
						if($zzza_lx == '1'){
							$zzza_zhuti1 = DB::result_first("SELECT count(*) FROM ".DB::table('forum_post')." WHERE authorid = '$_G[uid]' AND first = '1' AND fid IN($zzza_bankuair) AND dateline > '$tdateline' AND invisible = '0'");
							$zzza_tiezi1 = DB::result_first("SELECT count(*) FROM ".DB::table('forum_post')." WHERE authorid = '$_G[uid]' AND first = '0' AND fid IN($zzza_bankuair) AND dateline > '$tdateline' AND invisible = '0'");
							$zzza_tiezi = $zzza_zhuti1;
						}elseif($zzza_lx == '2'){
							$zzza_tiezi1 = DB::result_first("SELECT count(*) FROM ".DB::table('forum_post')." WHERE authorid = '$_G[uid]' AND first = '0' AND fid IN($zzza_bankuair) AND dateline > '$tdateline' AND invisible = '0'");
							$zzza_zhuti1 = DB::result_first("SELECT count(*) FROM ".DB::table('forum_post')." WHERE authorid = '$_G[uid]' AND first = '1' AND fid IN($zzza_bankuair) AND dateline > '$tdateline' AND invisible = '0'");
							$zzza_tiezi = $zzza_tiezi1;
						}elseif($zzza_lx == '3'){
							$zzza_tiezi1 = DB::result_first("SELECT count(*) FROM ".DB::table('forum_post')." WHERE authorid = '$_G[uid]' AND first = '0' AND fid IN($zzza_bankuair) AND dateline > '$tdateline' AND invisible = '0'");
							$zzza_zhuti1 = DB::result_first("SELECT count(*) FROM ".DB::table('forum_post')." WHERE authorid = '$_G[uid]' AND first = '1' AND fid IN($zzza_bankuair) AND dateline > '$tdateline' AND invisible = '0'");
							$zzza_jttz1 = DB::result_first("SELECT count(*) FROM ".DB::table('forum_post')." WHERE authorid = '$_G[uid]' AND fid IN($zzza_bankuair) AND dateline > '$tdateline' AND invisible = '0'");
							$zzza_tiezi = $zzza_jttz1;
						}
						$zzza_tiezi4 = $ftyj - $zzza_tiezi;//与插件设置的任务数量进行比较,通过差值的正负进行标记
						
					}else{
						//不做任务用户组,直接标记为已完成.
						$zzza_tiezi4 = 0;
					}
					if($set['zzza_txwz'] != '3'){
						$querya['lxyj'] = $querya['lxyj'] ? $querya['lxyj'] : 0;
						include template('yinxingfei_zzza:yinxingfei_zzza_tixing');
					}else{
						$return = '';
					}
					return $return;
				}
			}
		}
	}
}	
?>