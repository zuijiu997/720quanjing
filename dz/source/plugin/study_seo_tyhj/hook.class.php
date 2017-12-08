<?php
/*
// +----------------------------------------------------------------------
// | Copyright:    (c) 2013-2014 http://www.adminbuy.cn All rights reserved.
// +----------------------------------------------------------------------
// | Developer:    ABÄ£°åÍø
// +----------------------------------------------------------------------
// | Author:       ÀÏñÄ QQ:9490489
// +----------------------------------------------------------------------
 */
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_study_seo_tyhj {
	
}
class plugin_study_seo_tyhj_forum extends plugin_study_seo_tyhj{
//1 = ¹Ø±Õ
//2 = ±êÌâËÑË÷
//3 = ±êÇ©ËÑË÷
//4 = ¹Ø¼ü×ÖËÑË÷
	
	var $tyhj_keyword = array(); 
	function __construct() {
		global $_G;
		$return = array();
		$study_seo_tyhj = $_G['cache']['plugin']['study_seo_tyhj'];
		$study_fids = (array)unserialize($study_seo_tyhj['study_fids']);
		$study_gids = (array)unserialize($study_seo_tyhj['study_gids']);
		if(CURMODULE == 'viewthread' && in_array($_G['fid'],$study_fids) && in_array($_G['groupid'],$study_gids)){
			$this->tyhj_keyword = $this->_urlencode_diconv();
		}
  }
	
	function viewthread_posttop_output() {
		global $_G, $postlist;
		$return = array();
		$study_seo_tyhj = $_G['cache']['plugin']['study_seo_tyhj'];
		$study_fids = (array)unserialize($study_seo_tyhj['study_fids']);
		$study_gids = (array)unserialize($study_seo_tyhj['study_gids']);
		if(in_array($_G['fid'],$study_fids) && in_array($_G['groupid'],$study_gids)){
			if(in_array($study_seo_tyhj[study_posttop],array('2','3','4'))){
				$keyword = $this->tyhj_keyword[$study_seo_tyhj[study_posttop]];
				$specialbg = $study_seo_tyhj['study_specialbg'] ? $study_seo_tyhj['study_specialbg'] : $_G['style']['specialbg'];
				$study_border = $study_seo_tyhj['study_border'] ? $study_seo_tyhj['study_border'] : $_G['style']['commonborder'];
				$site = $this->tyhj_keyword[site];
				include template('study_seo_tyhj:posttop');
				$return[] = $posttop;
			}
		}
		return $return;
	}
	function viewthread_postfooter_output() {
		global $_G;
		$return = array();
		$study_seo_tyhj = $_G['cache']['plugin']['study_seo_tyhj'];
		$study_fids = (array)unserialize($study_seo_tyhj['study_fids']);
		$study_gids = (array)unserialize($study_seo_tyhj['study_gids']);
		if(in_array($_G['fid'],$study_fids) && in_array($_G['groupid'],$study_gids)){
			if(in_array($study_seo_tyhj[study_postfooter],array('2','3','4'))){
				$keyword = $this->tyhj_keyword[$study_seo_tyhj[study_postfooter]];
				$site = $this->tyhj_keyword[site];
				include template('study_seo_tyhj:postfooter');
				$return[] = $postfooter;
			}
		}
		//print_r($return);
		return $return;
	}
	function viewthread_postbottom_output() {
		global $_G;
		//$tyhj_keyword = $this->_urlencode_diconv($_G[thread][subject]);
		$return = array();
		$study_seo_tyhj = $_G['cache']['plugin']['study_seo_tyhj'];
		$study_fids = (array)unserialize($study_seo_tyhj['study_fids']);
		$study_gids = (array)unserialize($study_seo_tyhj['study_gids']);
		if(in_array($_G['fid'],$study_fids) && in_array($_G['groupid'],$study_gids)){
			if(in_array($study_seo_tyhj[study_postbottom],array('2','3','4'))){
				$keyword = $this->tyhj_keyword[$study_seo_tyhj[study_postbottom]];
				$tag = $this->tyhj_keyword[tag];
				$site = $this->tyhj_keyword[site];
				$specialbg = $study_seo_tyhj['study_specialbg'] ? $study_seo_tyhj['study_specialbg'] : $_G['style']['specialbg'];
				$study_border = $study_seo_tyhj['study_border'] ? $study_seo_tyhj['study_border'] : $_G['style']['commonborder'];
				include template('study_seo_tyhj:postbottom');
				$return[] = $postbottom.'<link rel="stylesheet" type="text/css" href="source/plugin/study_seo_tyhj/images/tyhj.css" />';
			}else{
				$return[] = '<link rel="stylesheet" type="text/css" href="source/plugin/study_seo_tyhj/images/tyhj.css" />';
			}
		}
		return $return;
	}
	
	function _urlencode_diconv() {
		global $_G, $postlist;
		$study_seo_tyhj = $_G['cache']['plugin']['study_seo_tyhj'];
		//2
		$tyhj_keyword[2][gbk] = urlencode(diconv($_G[thread][subject],CHARSET,'gb2312'));
		$tyhj_keyword[2][utf8] = urlencode(diconv($_G[thread][subject],CHARSET, 'utf-8'));	
		
		//3
		$flag_id = '';
		foreach($postlist as $id => $post) {
			$tags = $post[tags];
			$flag_id = $id;
			break;
		}
		if($tags){
			if(in_array($study_seo_tyhj[study_postbottom],array('2','3','4'))){
				$postlist[$flag_id][tags] = '';
				$tagi = 1314;
				if($study_seo_tyhj['study_tag_way'] == 2){
					foreach($tags as $var){
						if($tagi == 1314){
							$tyhj_keyword[tag] .= '<a title="'.$var[1].'" href="misc.php?mod=tag&name='.$var[1].'" target="_blank">'.$var[1].'</a>';
							$tagi = 'dly';
						}else{
							$tyhj_keyword[tag] .= ',<a title="'.$var[1].'" href="misc.php?mod=tag&name='.$var[1].'" target="_blank">'.$var[1].'</a>';
						}
					}
				}else{
					foreach($tags as $var){
						if($tagi == 1314){
							$tyhj_keyword[tag] .= '<a title="'.$var[1].'" href="misc.php?mod=tag&id='.$var[0].'" target="_blank">'.$var[1].'</a>';
							$tagi = 'dly';
						}else{
							$tyhj_keyword[tag] .= ',<a title="'.$var[1].'" href="misc.php?mod=tag&id='.$var[0].'" target="_blank">'.$var[1].'</a>';
						}
					}
				}
			}
			foreach($tags as $k => $tag) {
				$keyword .= $tag[1].' '; 
			}
			$tyhj_keyword[3][gbk] = urlencode(diconv($keyword,CHARSET,'gb2312'));
			$tyhj_keyword[3][utf8] = urlencode(diconv($keyword,CHARSET, 'utf-8'));
		}else{
			$tyhj_keyword[3] = $tyhj_keyword[2];
		}
		
		//4
		$keyword = $study_seo_tyhj['study_keyword'];
		if($keyword){
			$tyhj_keyword[4]['gbk'] = urlencode(diconv($keyword,CHARSET,'gb2312'));
			$tyhj_keyword[4]['utf8'] = urlencode(diconv($keyword,CHARSET, 'utf-8'));
		}else{
			$tyhj_keyword[4] = $tyhj_keyword[2];
		}
		if($study_seo_tyhj['study_site']){
			$tyhj_keyword['site'] =  '+site%3A'.$study_seo_tyhj['study_site'];
		}
		//$tyhj_keyword[site] +site%3A{$site_url}
		return $tyhj_keyword;
	}
}
?>