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
	global $_G;//加载系统全局变量
	
	//------------获取插件设置参数-------------------------------------------//
	
	$set = $_G['cache']['plugin']['yinxingfei_zzza'];
	$zzza_group = unserialize($set['zzza_group']);
    $zzza_bankuai = unserialize($set['zzza_bankuai']);
	$zzza_xsfs = $set['zzza_xsfs'];
	$zzza_wzkz = $set['zzza_wzkz'];
	$zzza_jf = $set['zzza_jifen'];
	$zzza_fw = $set['zzza_fw'];
	$jfzt = $set['zzza_jfzt'];
	$jstb = $set['zzza_jstb'];
	$zzza_img = $set['zzza_img'];
	$zdyiw1 = $set['zzza_zdyiw1'];
	$zdyiw2 = $set['zzza_zdyiw2'];
	$zdyiw3 = $set['zzza_zdyiw3'];
	$zdyiopen = $set['zzza_zdyiopen'];	
	$ftyj = $set['zzza_ftyj'];
	$bzpm = $set['zzza_bzpm'];
	$dbwz = $set['zzza_dbwz'];
	$dbwznr = $set['zzza_dbwznr'];	
	$dbwzys = $set['zzza_dbwzys'];	
	$wwcrw = $set['zzza_wwcrw'];
	$wcrwyh = $set['zzza_wcrwyh'];
	$yjfwsz = $set['zzza_yjfwsz'];
	$wfdyjfw = $set['zzza_wfdyjfw'];
	$zzza_lx = $set['zzza_lx'];
	$norw = unserialize($set['zzza_norw']);
	$zzza_bankuai = unserialize($set['zzza_bankuai']);
	$zzza_bankuai = array_filter($zzza_bankuai);
	$zzza_group = array_filter($zzza_group);
	$norw = array_filter($norw);
	$metakeywords = $set['zzza_kw'];
	$navtitle = $set['zzza_t'];
	$metadescription = $set['zzza_disc'];
	$zzza_link = $set['zzza_link'];
	$zzza_fyb = $set['zzza_fyb'];
	$zzza_jfmc = $_G['setting']['extcredits'][$zzza_jf]['title'];//获取积分名称
	//------------插件初始化数据-------------------------------------------//
	
	//检查用户是否登陆，没有登录就不执行初始化
	if(!$_G['uid'] || $_G['uid'] == 0) {
		
	}else{
		//检查是否属于运行参与摇奖的用户组
		
		if(!in_array($_G['groupid'], $zzza_group)){
			showmessage(lang("plugin/yinxingfei_zzza","wqssssaa"), '', array(), array('showmsg' => 1, 'alert' => 'error', 'showdialog' => 1));
		}else{
			//无分段摇奖范围参数进行切割
			$k22 = 0;
			$arrtx22 = explode("\n",$wfdyjfw);
			foreach ($arrtx22 as $anniuwenzi22){
				$k22++;
				if($k22<="1"){
				$listtx22[] = explode(",",$anniuwenzi22);
				}
			}
			
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
			
			
			
			//摇奖数据处理,今日未摇奖用户才进行处理,否则不处理
			if ($zzza_time == 0){
				//是否为首次积分录入判断
				$fwtimer = DB::fetch_first("SELECT * FROM ".DB::table('yinxingfei_zzza_time')." WHERE zzza_uid = '$_G[uid]'");
				$fwtime = empty($fwtimer['zzza_time']) ? 1 : $fwtimer['zzza_time'];
				
				$zzza_bankuair = implode(",",$zzza_bankuai);
				$zzza_bankuair = empty($zzza_bankuair) ? 0 : $zzza_bankuair;
				if($fwtime == '1'){//用户今天首次初始化摇奖积分,并且存入记录,更改标识为已经初始化首次为假"0"
					//开启有分段摇奖范围数据处理
					if( $yjfwsz == 1){			
						
						//2014-11-14 修改
						$list_hj = array();
						$query_hj = DB::query("SELECT * FROM ".DB::table('yinxingfei_zzza_fw')." WHERE id > 1");
						while($emot_hj = DB::fetch($query_hj)) {
							$list_hj[] = $emot_hj;
						}
						foreach ($list_hj as $key => $val) {   
							$arr[$val['id']] = $val['fwbfb'];   
						}
						//获得分段ID
						$jieguo = get_rand($arr);
						$isfw = DB::fetch_first("SELECT * FROM ".DB::table('yinxingfei_zzza_fw')." WHERE id = '$jieguo'");
						$isid2 = $isfw['id'] - 1;
						$isfwlowmin = DB::fetch_first("SELECT * FROM ".DB::table('yinxingfei_zzza_fw')." WHERE id = '$isid2'");
						$iffw_max2 = $isfwlowmin['fwcs'];//A分段的下限
						$iffw_max = $isfw['fwcs'];//A分段的上限
						$jlfwall = mt_rand($iffw_max2, $iffw_max);//在A分段范围获得一个数值,作为用户最终获得积分
						$zzza_jt1 = $jlfwall;
						/* print_r($arr);
						echo '</br>';echo '</br>';
						echo '选中分段ID：'.$jieguo;
						echo '</br>';echo '</br>';
						echo '下限:'.$iffw_max2;
						echo '</br>';echo '</br>';
						echo '上限:'.$iffw_max;
						echo '</br>';echo '</br>';
						echo '随机摇出结果：'.$jlfwall;
						exit; */
					//未开启有分段摇奖设置	
					}elseif($yjfwsz == 2){
						$isid4 = mt_rand($listtx22[0][0], $listtx22[0][1]);
						$zzza_jt1 = $isid4;
					}
					
					
					$is_sql_k =  DB::fetch_first("SELECT * FROM ".DB::table('yinxingfei_zzza_rank')." WHERE zzza_uid = '$_G[uid]'");
					$aaaaa = empty($is_sql_k['id']) ? 0 : $is_sql_k['id'] ;
					$istiezi = 	$is_sql_k['zzza_tiezi'];
					
					//用户首次摇奖则增加一条记录
					if( $aaaaa == '0'){
						$zzza_name = $_G[member][username];//获取当前用户的用户昵称
						DB::insert('yinxingfei_zzza_rank', array('zzza_uid' => $_G['uid'], 'zzza_name' => $zzza_name, 'jf_jt' => $zzza_jt1, 'jf_all' => 0, 'cj_cs' => 0, 'zzza_lasttime' => 0, 'zzza_lasttime_u' => 0, 'lxyj' => 0));
					}
					
					//用户最后摇奖时间初始化
					$is_sql_k2 =  DB::fetch_first("SELECT * FROM ".DB::table('yinxingfei_zzza_rank')." WHERE zzza_uid = '$_G[uid]'");
					$iszzza_lasttime1 =  $is_sql_k2['zzza_lasttime'];
					$iszzza_lasttime2 = dgmdate($_G['timestamp'],'Ymd',$_G['setting']['timeoffset']) - 1;//不管用户有多少天没来摇奖,我们都全部初始化为昨天摇过,方便处理,包括新用户首次记录,并且任务记录个数也初始化为"0"
					if($iszzza_lasttime1 < $iszzza_lasttime2){
						DB::query("UPDATE ".DB::table('yinxingfei_zzza_rank')." SET zzza_lasttime ='$iszzza_lasttime2' WHERE zzza_uid= '$_G[uid]'", 'UNBUFFERED');
					}
					
					DB::query("UPDATE ".DB::table('yinxingfei_zzza_rank')." SET jf_jt='$zzza_jt1' WHERE zzza_uid= '$_G[uid]'", 'UNBUFFERED');
					$zzza_jt = $zzza_jt1;
					//防止用户通过多浏览器刷积分代码,我们就通过首次记录为准,不管刷新多少次都是调用首次,
					$is_sql_k999 =  DB::fetch_first("SELECT * FROM ".DB::table('yinxingfei_zzza_time')." WHERE zzza_uid = '$_G[uid]'");
					$aaaaa999 = empty($is_sql_k999['id']) ? 0 : $is_sql_k999['id'] ;
					if( $aaaaa999 == '0'){
						DB::insert('yinxingfei_zzza_time', array('zzza_uid' => $_G['uid'], 'zzza_time' => '2'));//用户从未摇过奖,增加记录,并标识为首次
					}else{
						DB::query("UPDATE ".DB::table('yinxingfei_zzza_time')." SET zzza_time = '2' WHERE zzza_uid= '$_G[uid]'", 'UNBUFFERED');
					}					
				}else{//用户已经初始化摇奖积分,则直接调用首次初始化存入的
					$jf1 = DB::fetch_first("SELECT jf_jt FROM ".DB::table('yinxingfei_zzza_rank')." WHERE zzza_uid = '$_G[uid]'");
					$zzza_jt = $jf1['jf_jt'];
				}
				$tdateline = strtotime(date('Y-m-d',time()));
				//每日的摇奖任务统计
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
			}elseif( $zzza_time == 1){//已经摇过用户,直接显示今日摇出积分
				$zzza_jt = $jf['jf_jt'];
				$zzza_gewei_1 = $zzza_jt%10;
				$zzza_shiwei_1 = (($zzza_jt - $zzza_gewei_1)/10)%10;
				$zzza_baiwei_1 = ($zzza_jt - $zzza_gewei_1 - $zzza_shiwei_1*10)/100;
				$yjjs = $_GET['yjjs'];				
			}
		}
		
	}
	$zzza_jt = sprintf( "%03d",$zzza_jt);
	
	$zzza_today1 = dgmdate($_G['timestamp'],'Ymd',$_G['setting']['timeoffset']);
	
	//大厅排名数据
	$zzza_typeid = $_GET['typeid'];
	if(!$zzza_typeid){
		$zzza_typeid = 'today';
	}
	//今日最高
	if($zzza_typeid == 'today'){
		$limit = 14;
		$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('yinxingfei_zzza_rank')." WHERE zzza_uid >'0' AND zzza_lasttime = '$zzza_today1'");
		$page = max(1, intval($_GET['page']));
		$start_limit = ($page - 1) * $limit;
		$url = 'plugin.php?id=yinxingfei_zzza:yinxingfei_zzza_hall&typeid=today';
		$multipage = multi($num, $limit, $page, $url,0,4);
		$sql="SELECT * FROM ".DB::table('yinxingfei_zzza_rank')." WHERE zzza_lasttime = '$zzza_today1' ORDER BY jf_jt DESC , zzza_lasttime_u ASC LIMIT ".$start_limit." ,".$limit;
		$querygg=DB::query($sql);
		$zzzalist=array();
		$ggprint=array();
		$i = $start_limit + 1;
		while ($value=DB::fetch($querygg)){
			$zzzalist['zzza_uid'] = $value['zzza_uid'];
			$zzzalist['jf_jt'] = $value['jf_jt'];
			$zzzalist['zzza_name'] = $value['zzza_name'];
			if(!$value['zzza_name']){
				$zzzalist['zzza_name'] = getuserbyuidtoname($value['zzza_uid']);
			}
			//获取摇摇乐等级
            //等级规则:累积摇奖天数 + 累积奖励 然后除以10 取整
            $zzzadjdj = $value['jf_all'] + $value['cj_cs'];
            $zzzadjdj = $zzzadjdj/10 ;
            $zzzalist['zzzadjdj'] = zzzadj($zzzadjdj);
			$zzzalist['usernamec'] = cutstr($zzzalist['zzza_name'],10);
			$zzzalist['index'] = $i;
			$ggprint[$i]=$zzzalist;
			$i++;
		}	
	}elseif($zzza_typeid == 'alljl'){
		$limit = 14;
		$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('yinxingfei_zzza_rank')." WHERE zzza_uid >'0'  AND jf_all >'0'");
		$page = max(1, intval($_GET['page']));
		$start_limit = ($page - 1) * $limit;
		$url = 'plugin.php?id=yinxingfei_zzza:yinxingfei_zzza_hall&typeid=alljl';
		$multipage = multi($num, $limit, $page, $url,0,4);
		$sql="SELECT * FROM ".DB::table('yinxingfei_zzza_rank')." WHERE jf_all >'0' ORDER BY jf_all DESC , zzza_lasttime_u ASC LIMIT ".$start_limit." ,".$limit;
		$querygg=DB::query($sql);
		$zzzalist=array();
		$ggprint=array();
		$i = $start_limit + 1;
		while ($value=DB::fetch($querygg)){
			$zzzalist['zzza_uid'] = $value['zzza_uid'];
			$zzzalist['jf_jt'] = $value['jf_all'];
			$zzzalist['zzza_name'] = $value['zzza_name'];
			if(!$value['zzza_name']){
				$zzzalist['zzza_name'] = getuserbyuidtoname($value['zzza_uid']);
			}
			//获取摇摇乐等级
            //等级规则:累积摇奖天数 + 累积奖励 然后除以10 取整
            $zzzadjdj = $value['jf_all'] + $value['cj_cs'];
            $zzzadjdj = $zzzadjdj/10 ;
            $zzzalist['zzzadjdj'] = zzzadj($zzzadjdj);
			$zzzalist['usernamec'] = cutstr($zzzalist['zzza_name'],10);
			$zzzalist['index'] = $i;
			$ggprint[$i]=$zzzalist;
			$i++;
		}
	//连续摇奖	
	}elseif($zzza_typeid == 'lxyj'){
		$limit = 14;
		$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('yinxingfei_zzza_rank')." WHERE zzza_uid >'0'  AND lxyj >'0'");
		$page = max(1, intval($_GET['page']));
		$start_limit = ($page - 1) * $limit;
		$url = 'plugin.php?id=yinxingfei_zzza:yinxingfei_zzza_hall&typeid=lxyj';
		$multipage = multi($num, $limit, $page, $url,0,4);
		$sql="SELECT * FROM ".DB::table('yinxingfei_zzza_rank')." WHERE lxyj > '0' ORDER BY lxyj DESC , zzza_lasttime_u ASC LIMIT ".$start_limit." ,".$limit;
		$querygg=DB::query($sql);
		$zzzalist=array();
		$ggprint=array();
		$i = $start_limit + 1;
		while ($value=DB::fetch($querygg)){
			$zzzalist['zzza_uid'] = $value['zzza_uid'];
			$zzzalist['jf_jt'] = $value['lxyj'];
			$zzzalist['zzza_name'] = $value['zzza_name'];
			if(!$value['zzza_name']){
				$zzzalist['zzza_name'] = getuserbyuidtoname($value['zzza_uid']);
			}
			//获取摇摇乐等级
            //等级规则:累积摇奖天数 + 累积奖励 然后除以10 取整
            $zzzadjdj = $value['jf_all'] + $value['cj_cs'];
            $zzzadjdj = $zzzadjdj/10 ;
            $zzzalist['zzzadjdj'] = zzzadj($zzzadjdj);
			$zzzalist['usernamec'] = cutstr($zzzalist['zzza_name'],10);
			$zzzalist['index'] = $i;
			$ggprint[$i]=$zzzalist;
			$i++;
		}
	}
        //风云榜更新
        $fybrdays = DB::result_first("SELECT days FROM ".DB::table('yinxingfei_zzza_fyb')." ORDER BY id DESC LIMIT 0 , 1");
        $fybrdays = empty($fybrdays)? '-1' : $fybrdays;
	   if($fybrdays != $zzza_fyb && $fybrdays != '-1'){//检查后台设置是否对比前一次设置更改过
            //如果更改过,则更新风云榜数据
            DB::query("TRUNCATE ".DB::table('yinxingfei_zzza_fyb')."");// 清空旧数据
            $ylxyjpd = dgmdate($_G['timestamp'],'Ymd',$_G['setting']['timeoffset']);
            $yzzzayear=(int)substr($ylxyjpd,0,4);//取得年份
            $yzzzamonth=(int)substr($ylxyjpd,4,2);//取得月份
            $yzzzaday=(int)substr($ylxyjpd,6,2);//取得几号
            $yzzzamtime = mktime(0,0,0,$yzzzamonth,$yzzzaday,$yzzzayear);
            $zzza_fybdaya = $yzzzamtime - ($zzza_fyb*3600*24);
            $zzza_fybday = dgmdate($zzza_fybdaya,'Ymd',$_G['setting']['timeoffset']);
			$queryaafyb = DB::query("SELECT * FROM ".DB::table('yinxingfei_zzza_tj')." WHERE data > '$zzza_fybday' ORDER BY id DESC");
           
			$fyb_list = array();
            while($zzza_fyb_i = DB::fetch($queryaafyb)){
				
				$fyb_list[$zzza_fyb_i['uid']] += $zzza_fyb_i['jf_jt'];
				
				/*BUG FIX: $zzza_fyb_ilasttime = DB::result_first("SELECT zzza_lasttime_u FROM ".DB::table('yinxingfei_zzza_rank')." WHERE zzza_uid = '$zzza_fyb_i[uid]'");             
				$fybr = DB::result_first("SELECT COUNT(*) FROM ".DB::table('yinxingfei_zzza_fyb')." WHERE uid = '".$zzza_fyb_i['uid']."'");
				if($fybr == '0'){
					 DB::insert('yinxingfei_zzza_fyb', array('lasttime' => $zzza_fyb_ilasttime, 'uid' => $zzza_fyb_i['uid'], 'jf_all' => $zzza_fyb_i['jf_jt'], 'days' => $zzza_fyb));
				}else{
					$shangjfaaaa = DB::result_first("SELECT jf_all FROM ".DB::table('yinxingfei_zzza_fyb')." WHERE uid = '".$zzza_fyb_i['uid']."'");
					$fyball = $shangjfaaaa + $zzza_fyb_i['jf_jt'];
					DB::query("UPDATE ".DB::table('yinxingfei_zzza_fyb')." SET lasttime ='$zzza_fyb_ilasttime', jf_all = '$fyball', days = '$zzza_fyb' WHERE uid= '$_G[uid]'", 'UNBUFFERED');
				} */
            }
			foreach($fyb_list as $k => $v){
				$zzza_fyb_ilasttime = DB::result_first("SELECT zzza_lasttime_u FROM ".DB::table('yinxingfei_zzza_rank')." WHERE zzza_uid = '".$k."'");     
				DB::insert('yinxingfei_zzza_fyb', array('lasttime' => $zzza_fyb_ilasttime, 'uid' => $k, 'jf_all' => $v, 'days' => $zzza_fyb));
			}
            showmessage(lang("plugin/yinxingfei_zzza","fybgx"), 'plugin.php?id=yinxingfei_zzza:yinxingfei_zzza_hall');
       }
		
		//风云榜数据更新缓存
		
		$sqlz_fyb="SELECT * FROM ".DB::table('yinxingfei_zzza_fyb')." WHERE jf_all > '0' ORDER BY jf_all DESC , lasttime ASC LIMIT 0 ,10";
		$queryggz_fyb=DB::query($sqlz_fyb);
		$zzzalistz_fyb=array();
		$zzzalistz_fyb1=array();
		$iaaaaa = 1;
		while ($valuez_fyb=DB::fetch($queryggz_fyb)){
			$zzzalistz_fyb['zzza_uid'] = $valuez_fyb['uid'];
			$zzzalistz_fyb['jf_jt'] = $valuez_fyb['jf_all'];
			$zzzalistz_fyb['zzza_name'] = getuserbyuidtoname($valuez_fyb['uid']);
			$zzzalistz_fyb['usernamec'] = $zzzalistz_fyb['zzza_name'];
			$zzzalistz_fyb['index'] = $iaaaaa;
			$zzzalistz_fyb1[] = $zzzalistz_fyb;
			$iaaaaa++;
		}
	//统计信息
	$zzza_jtall=DB::result_first("SELECT COUNT(*) FROM ".DB::table('yinxingfei_zzza_rank')." WHERE zzza_uid > '0' AND zzza_lasttime = '$zzza_today1'");
	$zzza_jfall=DB::result_first("SELECT SUM(jf_jt) FROM ".DB::table('yinxingfei_zzza_rank')." WHERE zzza_uid > '0' AND zzza_lasttime = '$zzza_today1'");
	$zzza_jfall=empty($zzza_jfall) ? 0 : $zzza_jfall;
	if($_G['uid'] && $_G['uid'] != 0) {
		$is_sql_k3 =  DB::fetch_first("SELECT id ,zzza_uid FROM ".DB::table('yinxingfei_zzza_rank')." WHERE zzza_uid = '$_G[uid]'");
		$aaaa = empty($is_sql_k3['id']) ? 0 : $is_sql_k3['id'] ;
		$zzza_jtall=DB::result_first("SELECT COUNT(*) FROM ".DB::table('yinxingfei_zzza_rank')." WHERE zzza_uid > '0' AND zzza_lasttime = '$zzza_today1'");
		$zzza_u=DB::fetch_first("SELECT * FROM ".DB::table('yinxingfei_zzza_rank')." WHERE zzza_uid = '$_G[uid]'");
			
		$cdb_pper['zzza_uid'] = intval($_G['uid']);//获取当前用户UID
		$querya = DB::fetch_first("SELECT * FROM ".DB::table("yinxingfei_zzza_rank")." WHERE zzza_uid = '{$cdb_pper['zzza_uid']}'");
		if($querya){
			//今日你摇奖的时间排名
			$mycons = DB::result_first("SELECT COUNT(*) FROM ".DB::table('yinxingfei_zzza_rank')." WHERE zzza_lasttime_u > '{$querya['zzza_lasttime_u']}' AND zzza_lasttime = '$zzza_today1' OR (zzza_lasttime_u = '{$querya['zzza_lasttime_u']}' AND zzza_lasttime = '$zzza_today1')");
			//今日你摇奖的奖励排名,相同的话,根据摇奖时间来定
			$mycons2 = DB::result_first("SELECT COUNT(*) FROM ".DB::table('yinxingfei_zzza_rank')." WHERE jf_jt > '{$querya['jf_jt']}' AND zzza_lasttime = '$zzza_today1' OR (jf_jt = '{$querya['jf_jt']}' AND zzza_lasttime_u < '{$querya['zzza_lasttime_u']}' AND zzza_lasttime = '$zzza_today1')");
			//总奖励排名
			$myall = DB::result_first("SELECT COUNT(*) FROM ".DB::table('yinxingfei_zzza_rank')." WHERE jf_all > '{$querya['jf_all']}' OR (jf_all = '{$querya['jf_all']}' AND zzza_lasttime_u < '{$querya['zzza_lasttime_u']}')");
			$myall++;
			//总次数排名
			$mytimes = DB::result_first("SELECT COUNT(*) FROM ".DB::table('yinxingfei_zzza_rank')." WHERE cj_cs > '{$querya['cj_cs']}' OR (cj_cs = '{$querya['cj_cs']}' AND zzza_lasttime_u < '{$querya['zzza_lasttime_u']}')");
			$mytimes++;
            //连续天数排名
            $lxtsall = DB::result_first("SELECT COUNT(*) FROM ".DB::table('yinxingfei_zzza_rank')." WHERE lxyj > '{$querya['lxyj']}' OR (jf_all = '{$querya['lxyj']}' AND zzza_lasttime_u < '{$querya['zzza_lasttime_u']}')");
			$lxtsall++;
            //获取摇摇乐等级
            //等级规则:累积摇奖天数 + 累积奖励 然后除以10 取整
            $zzzadjdj = $querya['jf_all'] + $querya['cj_cs'];
            $zzzadjdj = $zzzadjdj/10 ;
            $zzzadjdj = zzzadj($zzzadjdj);
            
		}
		$zzza_u = $zzza_jtall - $mycons + 1;//今天多少人摇过
		$mycons1 = $mycons2 + 1;//今天你摇奖的奖励排名	
	}
	//打印本月日历表
		$zzza_today2 = strtotime(date('Ym',$_G['timestamp']).'01');//默认加载本月
		$zzza_year = date("Y", $zzza_today2);
		$zzza_month = date("m", $zzza_today2);
		$zzza_allday = date("t", $zzza_today2);
		$zzza_week = date("w",$zzza_today2);
		$zzza_list=array();
		$ggprinta=array();
		$zzza_iday = $zzza_allday + 1 + $zzza_week;
		$zzza_idaynum = 1;
		$rilii = 1;		
		while ($zzza_idaynum  != $zzza_iday){
			if($zzza_idaynum <= $zzza_week){
				$zzza_list['day'] = '&nbsp;';
			}else{
				$zzza_list['day'] = $zzza_idaynum - $zzza_week;
				if($zzza_list['day'] < 10){
					$zzza_list['data'] = $zzza_year.$zzza_month."0".$zzza_list['day'];
				}else{
					$zzza_list['data'] = $zzza_year.$zzza_month.$zzza_list['day'];
				}
				$zzza_list['yjyj'] = DB::result_first("SELECT count(*) FROM ".DB::table('yinxingfei_zzza_tj')." WHERE uid = '$_G[uid]' AND data = '$zzza_list[data]'");
				if($zzza_list['yjyj'] > 0){
					$zzza_lista = DB::fetch_first("SELECT * FROM ".DB::table('yinxingfei_zzza_tj')." WHERE uid = '$_G[uid]' AND data = '$zzza_list[data]'");
					$zzza_list['lasttime'] = date("H".lang("plugin/yinxingfei_zzza","zzzah")."i".lang("plugin/yinxingfei_zzza","zzzaf")."s".lang("plugin/yinxingfei_zzza","zzzam")."", $zzza_lista['lasttime'] );
					$zzza_list['jf_jt'] =$zzza_lista['jf_jt'];
					$zzza_list['jf_name'] = $zzza_lista['jf_name'];
					$zzza_today1 = $zzza_list['data'];
					$zzza_list['yjdi'] = DB::result_first("SELECT COUNT(*) FROM ".DB::table('yinxingfei_zzza_tj')." WHERE lasttime < '{$zzza_lista['lasttime']}' AND data = '$zzza_today1' OR (lasttime = '{$zzza_lista['lasttime']}' AND data = '$zzza_today1')");
				}
			}
			$zzza_list['index'] = $rilii;
			$ggprinta[] = $zzza_list;
			$zzza_idaynum++;
			$rilii++;
		}
		$zzza_listi['ljcs'] = DB::result_first("SELECT cj_cs FROM ".DB::table('yinxingfei_zzza_rank')." WHERE zzza_uid = '$_G[uid]'");
		$zzza_listi['lxcs'] = DB::result_first("SELECT lxyj FROM ".DB::table('yinxingfei_zzza_rank')." WHERE zzza_uid = '$_G[uid]'");
		$zzza_listi['ljcs'] = empty($zzza_listi['ljcs'])? 0 : $zzza_listi['ljcs'];
		$zzza_listi['lxcs'] = empty($zzza_listi['lxcs'])? 0 : $zzza_listi['lxcs'];

	//加载页面
	if(defined('IN_MOBILE')) {
		include template('yinxingfei_zzza:yinxingfei_zzza_hall');
	}else{
		include template('diy:yinxingfei_zzza_hall', 2, 'source/plugin/yinxingfei_zzza/template');
	}
	

	function randomnum($min = 0, $max = 100) {
		PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
		$num = mt_rand($min, $max);
		return $num;
	}
    function zzzadj($a){
		$a = intval($a);
        $zdxx = DB::result_first("SELECT xx FROM ".DB::table('yinxingfei_zzza_dj')." WHERE id = '1'");
        $zgsx = DB::result_first("SELECT sx FROM ".DB::table('yinxingfei_zzza_dj')." WHERE id = '20'");
        if($a < $zdxx){
            $dj = 0;
        }elseif($a > $zgsx){
            $dj = 20;
        }else{
            $dj = DB::result_first("SELECT id FROM ".DB::table('yinxingfei_zzza_dj')." WHERE xx <= '$a' AND sx > '$a'");
        }
        return $dj;
    }
    function getuserbyuidtoname($id){
        $id = DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid = '$id'");
        return $id;
    }
	/* 
	 * 经典的概率算法， 
	 * $proArr是一个预先设置的数组， 
	 * 假设数组为：array(100,200,300，400)， 
	 * 开始是从1,1000 这个概率范围内筛选第一个数是否在他的出现概率范围之内，  
	 * 如果不在，则将概率空间，也就是k的值减去刚刚的那个数字的概率空间， 
	 * 在本例当中就是减去100，也就是说第二个数是在1，900这个范围内筛选的。 
	 * 这样 筛选到最终，总会有一个数满足要求。 
	 * 就相当于去一个箱子里摸东西， 
	 * 第一个不是，第二个不是，第三个还不是，那最后一个一定是。 
	 * 这个算法简单，而且效率非常 高， 
	 * 关键是这个算法已在我们以前的项目中有应用，尤其是大数据量的项目中效率非常棒。 
	 */  
	function get_rand($proArr) {   
		$result = '';    
		//概率数组的总概率精度   
		$proSum = array_sum($proArr);    
		//概率数组循环   
		foreach ($proArr as $key => $proCur) {   
			$randNum = mt_rand(1, $proSum);   
			if ($randNum <= $proCur) {   
				$result = $key;   
				break;   
			} else {   
				$proSum -= $proCur;   
			}         
		}   
		unset ($proArr);    
		return $result;   
	}
?>