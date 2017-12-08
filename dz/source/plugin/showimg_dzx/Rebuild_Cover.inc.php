<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if($_GET['paction'] == "full"){
	//echo "select * from ".DB::table("forum_thread")." A,".DB::table("forum_post")." B where A.tid = B.tid and B.first=1 and A.fid=".$_GET['forums'];
	//exit;
	$do = intval($_GET['do']);
	$fid = intval($_GET['forums']);
	$processed = 0;
	$pertask = intval($_GET['pertask']); //每个循环数
	$next = intval($_GET['next']);
	if($next){
		$current = $next*$pertask;
	}else{
		$current = 0;
	}
	$next = $next+1;
	$nextlink = 'action=plugins&operation=config&do='.$do.'&identifier=showimg_dzx&pmod=Rebuild_Cover&paction=full&forums='.$fid.'&next='.$next.'&pertask='.$pertask;
	
	$starttime = strtotime($_GET['starttime']);
	$endtime = strtotime($_GET['endtime']);
	$timesql = '';
	if($starttime) {
		$timesql .= " AND A.lastpost > $starttime";
		$nextlink .= '&starttime='.$_GET['starttime'];
	}
	if($endtime) {
		$timesql .= " AND A.lastpost < $endtime";
		$nextlink .= '&endtime='.$_GET['endtime'];
	}
	
	
	$query = DB::query("SELECT A.tid,A.fid,B.pid,B.attachment,B.message FROM ".DB::table("forum_thread")." A,".DB::table("forum_post")." B where A.tid = B.tid and A.displayorder >= 0 and B.first=1 and A.fid=".$fid.$timesql." ORDER BY A.lastpost DESC LIMIT {$current},{$pertask}");
	

	//判断版块是否是图片瀑布流
	loadcache('plugin');
	loadcache('forums');


	while($thread = DB::fetch($query)){
		$processed = 1;
		$fid = $thread['fid'];
		$forumset = unserialize($_G['cache']['forums'][$fid]['plugin']['showimg_dzx']['forum_setting']);
		if($forumset['forum_type']==3){
			$imgtype = 2;
		}else{
			$imgtype = 1;
		}
		if($thread['attachment']==2){
			$post = DB::fetch_first("SELECT aid FROM ".DB::table(forum_attachment)." WHERE tid=".$thread['tid']." ORDER BY aid");
			//生成封面
			mysetthreadcover($thread['pid'],$thread['tid'],$post['aid'],0,'',$imgtype,$fid);
		}else{
			//外链图片生成封面
			preg_match("/\[img(.*)\](.+?)\[\/img\]/is",$thread['message'],$match);
			mysetthreadcover($thread['pid'],$thread['tid'],0,0,$match[2],$imgtype,$fid);
		}
		
		//多图封面
		if($forumset['forum_type']==5){  //多图模式生成缩略图
			if($thread['attachment']==2){
				$imgheight = $forumset['pic_height'];
				$imgwidth = $forumset['pic_width'];
				if($imgwidth<1 or $imgheight<1){
					$imgheight = 68;
					$imgwidth = 91;
				}
				$i = 1;
				$query = DB::query("SELECT aid FROM ".DB::table(forum_attachment)." WHERE tid=".$thread['tid']." ORDER BY aid");
				require_once libfile('class/image');
				while($value = DB::fetch($query)){
						$aid = $value['aid'];
						$attachtable = 'aid:'.$aid;
						$attach = C::t('forum_attachment_n')->fetch('aid:'.$aid, $aid, array(1, -1));
						$picsource = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']).'forum/'.$attach['attachment'];
						$image = new image();
						$thumb = $image->Thumb($picsource, '', $imgwidth, $imgheight, 1, 0);
						$i++;
				}
			}
		}
		
		
		
		//print_r($thread);
	}
	if($processed) {
		$nextcurrent = $next*$pertask;
		cpmsg("$lang[counter_thread_cover]: ".cplang('counter_processing', array('current' => $current, 'next' => $nextcurrent)), $nextlink, 'loading');
	} else {
		cpmsg('counter_thread_cover_succeed', 'action=plugins&operation=config&do='.$do.'&identifier=showimg_dzx&pmod=Rebuild_Cover', 'succeed');
	}
}else{
	showtips('counter_tips');
	require_once libfile('function/forumlist');
	$forumlist = forumselect(FALSE, 0, 0, TRUE);
	include template('showimg_dzx:rebuild_cover');
}



//生成封面图片 $imgtype 1是一般封面，2是瀑布流封面
function mysetthreadcover($pid, $tid = 0, $aid = 0, $countimg = 0, $imgurl = '',$imgtype = 1,$fid) { 

	global $_G;
	$cover = 0;
	//图片大小
	$forumset = unserialize($_G['cache']['forums'][$fid]['plugin']['showimg_dzx']['forum_setting']);
	if($imgtype==1){
		$imgheight = $forumset['pic_height'];
		$imgwidth = $forumset['pic_width'];
		if($imgwidth<1 or $imgheight<1){
			$imgheight = 68;
			$imgwidth = 91;
		}
	}else{
		$imgwidth = $forumset['pic_width'];
		$imgheight = 9999;
	}
	
	
	
	
	
	if(empty($_G['uid']) || !intval($imgheight) || !intval($imgwidth)) {
		return false;
	}

	if(($pid || $aid) && empty($countimg)) {
		if(empty($imgurl)) {
			if($aid) {
				$attachtable = 'aid:'.$aid;
				$attach = C::t('forum_attachment_n')->fetch('aid:'.$aid, $aid, array(1, -1));
			} else {
				$attachtable = 'pid:'.$pid;
				$attach = C::t('forum_attachment_n')->fetch_max_image('pid:'.$pid, 'pid', $pid);
			}
			if(!$attach) {
				return false;
			}
			$pid = empty($pid) ? $attach['pid'] : $pid;
			$tid = empty($tid) ? $attach['tid'] : $tid;
			$picsource = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']).'forum/'.$attach['attachment'];
		} else {
			$attachtable = 'pid:'.$pid;
			$picsource = $imgurl;
		}
		

		$basedir = !$_G['setting']['attachdir'] ? (DISCUZ_ROOT.'./data/attachment/') : $_G['setting']['attachdir'];
		$coverdir = 'threadcover/'.substr(md5($tid), 0, 2).'/'.substr(md5($tid), 2, 2).'/';
		dmkdir($basedir.'./forum/'.$coverdir);

		require_once libfile('class/image');
		$image = new image();
		
		if($image->Thumb($picsource, 'forum/'.$coverdir.$tid.'.jpg', $imgwidth, $imgheight, 2)) {
			$remote = '';
			if(getglobal('setting/ftp/on')) {
				if(ftpcmd('upload', 'forum/'.$coverdir.$tid.'.jpg')) {
					$remote = '-';
				}
			}
			$cover = C::t('forum_attachment_n')->count_image_by_id($attachtable, 'pid', $pid);
			if($imgurl && empty($cover)) {
				$cover = 1;
			}
			$cover = $remote.$cover;
		} else {
			return false;
		}
	}
	if($countimg) {
		if(empty($cover)) {
			$thread = C::t('forum_thread')->fetch($tid);
			$oldcover = $thread['cover'];

			$cover = C::t('forum_attachment_n')->count_image_by_id('tid:'.$tid, 'pid', $pid);
			if($cover) {
				$cover = $oldcover < 0 ? '-'.$cover : $cover;
			}
		}
	}
	if($cover) {
		C::t('forum_thread')->update($tid, array('cover' => $cover));
		return true;
	}
}

?>