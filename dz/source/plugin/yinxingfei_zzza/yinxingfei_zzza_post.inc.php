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
if($_POST['formhash']==FORMHASH){
	
	global $_G;//获取全局变量
	$set					=					$_G['cache']['plugin']['yinxingfei_zzza'];//加载插件参数
	$zzza_lx				= 					$set['zzza_lx'];//任务类型
	$zzza_link				= 					$set['zzza_link'];//伪静态链接
	$homeurl				= 					$zzza_link;
	$zzza_ftyj	 			= 					$set['zzza_ftyj'];//今日任务数量 
	$norw 					= 					unserialize($set['zzza_norw']);//不做任务用户组
	$zzza_bankuai 			= 					unserialize($set['zzza_bankuai']);//发帖任务版块
	$zzza_group 			= 					unserialize($set['zzza_group']);
	$zzza_bankuai = unserialize($set['zzza_bankuai']);
	$zzza_fyb = $set['zzza_fyb'];
	$zzza_bankuai = array_filter($zzza_bankuai);
	$zzza_group = array_filter($zzza_group);
	$norw = array_filter($norw);
	//检查用户是否登陆，没有登录就不执行初始化
	if(!$_G['uid'] || $_G['uid'] == 0) {
		header("Location: $homeurl");
		exit;
	}
	//检查是否属于运行参与摇奖的用户组
	
	if(!in_array($_G['groupid'], $zzza_group)){
		header("Location: $homeurl");
		exit;
	}
	$zzza_bankuair = implode(",",$zzza_bankuai);
	$zzza_bankuair = empty($zzza_bankuair) ? 0 : $zzza_bankuair;
	$tdateline = strtotime(date('Y-m-d',time()));
				//每日的摇奖任务统计
				if(!in_array($_G['groupid'], $norw) && $zzza_ftyj != '0'){//判断是否为需要做任务的用户组
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
					$zzza_tiezi4 = $zzza_ftyj - $zzza_tiezi;//与插件设置的任务数量进行比较,通过差值的正负进行标记
					
				}else{
					//不做任务用户组,直接标记为已完成.
					$zzza_tiezi4 = 0;
				}
	$zzza_jt 			= 			DB::result_first("SELECT jf_jt FROM ".DB::table('yinxingfei_zzza_rank')." WHERE zzza_uid = '$_G[uid]'");//今天所得积分
	$getcreditnum 		= 			$zzza_jt;
	$fileURI 			= 			$homeurl;//跳转链接
	$zzza_credit 		= 			$set['zzza_jifen'];//积分类型
	$jf 				= 			DB::fetch_first("SELECT * FROM ".DB::table('yinxingfei_zzza_rank')." WHERE zzza_uid = $_G[uid]");
	$zza_td_time 		= 			dgmdate($_G['timestamp'],'Ymd',$_G['setting']['timeoffset']);//今天日期
	$zza_td_time_u 		= 			$_G['timestamp'];//最后摇奖时间
	$zzza_timeis 		= 			$jf['zzza_lasttime'];//用户上次摇奖日期
	$zzza_jf 			= 			$set['zzza_jifen'];
	$zzza_jfmc 			= 			$_G['setting']['extcredits'][$zzza_jf]['title'];//获取积分名称
	if($zzza_tiezi4 > 0){//检测未完成任务,则提示
		showmessage(lang("plugin/yinxingfei_zzza","hmwcewaa"), $fileURI, array(), array('showmsg' => 1, 'alert' => 'error', 'showdialog' => 1));
	}else{
		if( $zza_td_time != $zzza_timeis ){//检查用户今日是否摇过奖
			$cj_cs = $jf['cj_cs'];//获取上次总摇奖次数
			$cj_cs++;
			$jf_all = $jf['jf_all'] + $getcreditnum;//总摇奖积分增加
			$zzza_lasstime_jt = $zza_td_time;
			$zzza_name = daddslashes($_G[member][username]);
			$lxyjpd = dgmdate($jf['zzza_lasttime_u'],'Ymd',$_G['setting']['timeoffset']);
			$zzzayear=(int)substr($zzza_lasstime_jt,0,4);//取得年份
			$zzzamonth=(int)substr($zzza_lasstime_jt,4,2);//取得月份
			$zzzaday=(int)substr($zzza_lasstime_jt,6,2);//取得几号
			$zzzamtime = mktime(0,0,0,$zzzamonth,$zzzaday,$zzzayear);
			$zzzanyear=(int)substr($lxyjpd,0,4);//取得年份
			$zzzanmonth=(int)substr($lxyjpd,4,2);//取得月份
			$zzzanday=(int)substr($lxyjpd,6,2);//取得几号
			$zzzantime = mktime(0,0,0,$zzzanmonth,$zzzanday,$zzzanyear);
			$zzzajtime = ($zzzamtime - $zzzantime)/(3600*24);
			if($zzzajtime <= 1){
				if($zzzajtime == 1){
					$lxyj = $jf['lxyj'];
					$lxyj++;
				}else{
					$lxyj = $jf['lxyj'];
				}
			}else{
				$lxyj = 0;
			}
			updatemembercount($_G['uid'], array ($zzza_credit => $getcreditnum),'','','',lang("plugin/yinxingfei_zzza","jl_aa"),lang("plugin/yinxingfei_zzza","jl_bb"),lang("plugin/yinxingfei_zzza","jl_cc"));//增加积分
			//更新数据
			DB::query("UPDATE ".DB::table('yinxingfei_zzza_rank')." SET zzza_name='$zzza_name', jf_jt='$getcreditnum', jf_all='$jf_all' , cj_cs='$cj_cs', zzza_lasttime='$zzza_lasstime_jt', zzza_lasttime_u='$zza_td_time_u', lxyj = '$lxyj' WHERE zzza_uid= '$_G[uid]'", 'UNBUFFERED');
			DB::query("UPDATE ".DB::table('yinxingfei_zzza_time')." SET zzza_time= '1' WHERE zzza_uid= '$_G[uid]'", 'UNBUFFERED');
			//新增日历表统计
			DB::insert('yinxingfei_zzza_tj', array('data' => dgmdate($_G['timestamp'],'Ymd',$_G['setting']['timeoffset']), 'uid' => $_G['uid'], 'jf_jt' => $getcreditnum, 'jf_name' => $zzza_jfmc, 'lasttime' => $zza_td_time_u));
			//更新风云榜名统计
			$ylxyjpd = dgmdate($_G['timestamp'],'Ymd',$_G['setting']['timeoffset']);
			$yzzzayear=(int)substr($ylxyjpd,0,4);//取得年份
			$yzzzamonth=(int)substr($ylxyjpd,4,2);//取得月份
			$yzzzaday=(int)substr($ylxyjpd,6,2);//取得几号
			$yzzzamtime = mktime(0,0,0,$yzzzamonth,$yzzzaday,$yzzzayear);
			$zzza_fybdaya = $yzzzamtime - ($zzza_fyb*3600*24);
			$zzza_fybday = dgmdate($zzza_fybdaya,'Ymd',$_G['setting']['timeoffset']);
			$zzza_fyball = DB::result_first("SELECT SUM(jf_jt) FROM ".DB::table('yinxingfei_zzza_tj')." WHERE data > '$zzza_fybday' AND uid = '$_G[uid]'");
			$fybr = DB::result_first("SELECT COUNT(*) FROM ".DB::table('yinxingfei_zzza_fyb')." WHERE uid = '$_G[uid]'");
			if($fybr == '0'){
				DB::insert('yinxingfei_zzza_fyb', array('lasttime' => $zza_td_time_u, 'uid' => $_G['uid'], 'jf_all' => $zzza_fyball, 'days' => $zzza_fyb));
			}else{
				$fyball = $zzza_fyball;
				//$fyball = $getcreditnum;
				DB::query("UPDATE ".DB::table('yinxingfei_zzza_fyb')." SET lasttime ='$zza_td_time_u', jf_all = '$fyball', days = '$zzza_fyb' WHERE uid= '$_G[uid]'", 'UNBUFFERED');
			}
			$homeurla = 'plugin.php?id=yinxingfei_zzza:yinxingfei_zzza_hall&yjjs=yes';
			header("Location: $homeurla");//返回大厅
			exit;
		}else{
			showmessage(lang('plugin/yinxingfei_zzza', 'zzza'), $fileURI, array(), array('showmsg' => 1, 'alert' => 'error', 'showdialog' => 1));
		}
	}	
}else{	
	showmessage(lang('plugin/yinxingfei_zzza', 'ffqq'), '', array(), array('showmsg' => 1, 'alert' => 'error', 'showdialog' => 1));
}
?>