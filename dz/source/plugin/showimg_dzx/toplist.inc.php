<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
echo '<?xml version="1.0" encoding="gb2312"?>';

$fid=intval($_GET['fid']);
$digests = (array)unserialize($_G['cache']['plugin']['showimg_dzx']['toplist_class']);
$num = (int)$_G['cache']['plugin']['showimg_dzx']['toplist_number'];

if(!empty($fid) and $fid!='undefined'){
	$query = DB::query("SELECT a.tid,a.cover,a.subject,b.attachment FROM ".DB::table('forum_thread')." a,".DB::table('forum_threadimage')." b WHERE a.tid=b.tid and a.displayorder>=0 and a.fid='$fid' and digest in(".implode(",",$digests).") order by a.lastpost desc limit ".$num);
}else{
	$query = DB::query("SELECT a.tid,a.cover,a.subject,b.attachment FROM ".DB::table('forum_thread')." a,".DB::table('forum_threadimage')." b WHERE a.tid=b.tid and a.displayorder>=0 and digest in(".implode(",",$digests).") order by a.lastpost desc limit ".$num);
}
$piclist = array();
while($row = DB::fetch($query)){
	$row['coverpic'] = getthreadcover($row['tid'], $row['cover']);
	if(empty($row['coverpic'])){
		$row['coverpic'] = "data/attachment/forum/".$row["attachment"];
	}
	
	$piclist[] = $row;
}


include template('showimg_dzx:toplist');


function getthreadcover($tid, $cover = 0, $getfilename = 0) {
	global $_G;
	if(empty($tid)) {
		return '';
	}
	$coverpath = '';
	$covername = 'threadcover/'.substr(md5($tid), 0, 2).'/'.substr(md5($tid), 2, 2).'/'.$tid.'.jpg';
	if($getfilename) {
		return $covername;
	}
	if($cover) {
		$coverpath = ($cover < 0 ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']).'forum/'.$covername;
	}
	return $coverpath;
}
?>