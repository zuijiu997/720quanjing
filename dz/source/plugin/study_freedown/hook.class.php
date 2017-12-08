<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * From www.1314study.com
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
class plugin_study_freedown {
		public function common($param) {
				global $_G;
				if(CURSCRIPT == 'forum'){
						$splugin_setting = $_G['cache']['plugin']['study_freedown'];
						$study_fids = unserialize($splugin_setting['study_fids']);
						$splugin_setting['study_userfreedown'] = explode("\n", str_replace("\r\n", "\n", $splugin_setting['study_userfreedown']));
						foreach($splugin_setting['study_userfreedown'] as $value){
								$value = explode("=", $value);
								$value = dintval($value, true);
								if($value[0] && $value[1]){
										$study_userfreedown[$value[0]] = $value;
								}
						}
						if($study_userfreedown[$_G['groupid']]){
								if(CURMODULE == 'misc' && in_array($_G['fid'], $study_fids)){
										if(getgpc('action') == 'attachpay' && !$_GET['attachpay'] && !$_GET['paysubmit']){
												require_once libfile('function/attachment');
												$aid = intval($_GET['aid']);
												$tid = intval($_GET['tid']);
												$url = $_G['siteurl']."forum.php?mod=attachment&aid=".aidencode($aid, 0, $tid);
												$attinfo = DB::fetch_first("SELECT tid,downloads FROM ".DB::table('forum_attachment')." WHERE aid='$aid'");
												if($attinfo['tid']){
												    $attachment = DB::fetch_first("SELECT * FROM ".DB::table(getattachtablebytid($attinfo['tid']))." WHERE aid='$aid'");
														$attachment = dhtmlspecialchars($attachment);
														$attachment['filename'] = $attachment['filename'];
														$attachment['filesize'] = sizecount($attachment['filesize']);
														$attachment['dateline'] = gmdate("Y-m-d" , $attachment['dateline'] + $_G['setting']['timeoffset'] * 3600 );
														$attachment['downloads'] = $attinfo['downloads'];
														$attachment['attachtype'] = attachtype(strtolower(fileext($attachment['filename']))."\t".$attachment['filetype']);
														
														$study_freetime = $splugin_setting['study_freetime'] ? $splugin_setting['study_freetime'] : 3600;
														$log = C::t('#study_freedown#study_freedown_log')->fetch_first_by_aid_uid($aid, $_G['uid']);
														if($_G['timestamp'] - $log['dateline'] > $study_freetime){
																$todaytime = strtotime(date('Y-m-d', intval($_G['timestamp'])));
																$count = C::t('#study_freedown#study_freedown_log')->count_by_aid_uid($_G['uid'], $todaytime);
																$surplus = $study_userfreedown[$_G['groupid']][1] - $count;
														}else{
																$endtime = gmdate("Y-m-d h:i" , $log['dateline'] + $study_freetime + $_G['setting']['timeoffset'] * 3600 );
														}

														include template("study_freedown:down");
														exit();
												}
										}
								}elseif(CURMODULE == 'attachment'){
										$freedown = 0;
										$study_freetime = $splugin_setting['study_freetime'] ? $splugin_setting['study_freetime'] : 3600;
										include_once DISCUZ_ROOT.'/source/plugin/study_freedown/forum_attachment.php';
										exit();
								}
						}
				}
		}
		public function set_freedown_log($study_userfreedown, $study_freetime) {
			global $_G;
			$log = C::t('#study_freedown#study_freedown_log')->fetch_first_by_aid_uid($aid, $_G['uid']);
			if($_G['timestamp'] - $log['dateline'] > $study_freetime){
					$todaytime = strtotime(date('Y-m-d', intval($_G['timestamp'])));
					$count = C::t('#study_freedown#study_freedown_log')->count_by_aid_uid($_G['uid'], $todaytime);
					if($count < $study_userfreedown[$_G['groupid']][1]){
							$data = array('aid' => $aid, 'uid'=> intval($_G['uid']), 'ip'=> $_G['clientip'], 'dateline'=> $_G['timestamp']);
							C::t('#study_freedown#study_freedown_log')->insert($data);
							$freedown = 1;
					}else{
							$freedown = -1;
					}
			}else{
					$freedown = 1;
			}
		}
}

?>