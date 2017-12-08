<?php
if(!defined('IN_DISCUZ')) {
exit('Access Denied');
}

class plugin_showimg_dzx{



	function forumdisplay_output() {
		global $_G;
	
		$fid = getgpc('fid');
		if($fid) {
			$fid = is_numeric($fid) ? intval($fid) : (!empty($_G['setting']['forumfids'][$fid]) ? $_G['setting']['forumfids'][$fid] : 0);
		}
		$forumset = unserialize($_G['cache']['forums'][$fid]['plugin']['showimg_dzx']['forum_setting']);
		$forumset['wf_pages'] = $forumset['wf_pages']?$forumset['wf_pages']:5;
		

		if(in_array(0,$forumset['content_show'])){
			$content_show = 1;
		}

		if($forumset['forum_type'] >= 3 and $forumset['forum_type']<5){
			$forumname = strip_tags($_G['forum']['name']);
			//设置SEO
			$navtitle = strip_tags($_G['forum']['name']);
			//$_G['forum']['name'] = $_G['forum']['seotitle'];
			$metakeywords = $_G['forum']['keywords'];
			$metadescription = $_G['forum']['seodescription'];
			if(!$metakeywords) {
				$metakeywords = $_G['forum']['name'];
			}
			if(!$metadescription) {
				$metadescription = $_G['forum']['name'];
			}

			//子版块
			foreach($_G['cache']['forums'] as $sub) {
				if($sub['type'] == 'sub' && $sub['fup'] == $_G['fid'] && (!$_G['setting']['hideprivate'] || !$sub['viewperm'] || forumperm($sub['viewperm']) || strstr($sub['users'], "\t$_G[uid]\t"))) {
					if(!$sub['status']) {
						continue;
					}
					$subexists = 1;
					$sublist = array();
					$query = C::t('forum_forum')->fetch_all_info_by_fids(0, 'available', 0, $_G['fid'], 1, 0, 0, 'sub');
			
					if(!empty($_G['member']['accessmasks'])) {
						$fids = array_keys($query);
						$accesslist = C::t('forum_access')->fetch_all_by_fid_uid($fids, $_G['uid']);
						foreach($query as $key => $val) {
							$query[$key]['allowview'] = $accesslist[$key];
						}
					}
					foreach($query as $sub) {
						$sub['extra'] = dunserialize($sub['extra']);
						if(!is_array($sub['extra'])) {
							$sub['extra'] = array();
						}
						if(forum($sub)) {
							$sub['orderid'] = count($sublist);
							$sublist[] = $sub;
						}
					}
					break;
				}
			}
			if($subexists) {
				if($_G['forum']['forumcolumns']) {
					$_G['forum']['forumcolwidth'] = (floor(100 / $_G['forum']['forumcolumns']) - 0.1).'%';
					$_G['forum']['subscount'] = count($sublist);
					$_G['forum']['endrows'] = '';
					if($colspan = $_G['forum']['subscount'] % $_G['forum']['forumcolumns']) {
						while(($_G['forum']['forumcolumns'] - $colspan) > 0) {
							$_G['forum']['endrows'] .= '<td>&nbsp;</td>';
							$colspan ++;
						}
						$_G['forum']['endrows'] .= '</tr>';
					}
				}
				if(empty($_G['cookie']['collapse']) || strpos($_G['cookie']['collapse'], 'subforum_'.$_G['fid']) === FALSE) {
					$collapse['subforum'] = '';
					$collapseimg['subforum'] = 'collapsed_no.gif';
				} else {
					$collapse['subforum'] = 'display: none';
					$collapseimg['subforum'] = 'collapsed_yes.gif';
				}
			}
		
		
			if(!empty($_GET['forumdefstyle'])){   //设置文字还是图片模式
				$forumdefstyle = isset($_GET['forumdefstyle']) ? $_GET['forumdefstyle'] : '';
				if($forumdefstyle) {
					switch($forumdefstyle) {
						case 'no': dsetcookie('forumdefstyle', ''); break;
						case 'yes': dsetcookie('forumdefstyle', 1, 31536000); break;
					}
				}
			}
			//版规展开、关闭图片
			if(!isset($_G['cookie']['collapse']) || strpos($_G['cookie']['collapse'], 'forum_rules_'.$_G['fid']) === FALSE) {
				$collapse['forum_rules'] = '';
				$collapse['forum_rulesimg'] = 'no';
			} else {
				$collapse['forum_rules'] = 'display: none';
				$collapse['forum_rulesimg'] = 'yes';
			}
		
		
			if($_GET['mod']=='forumdisplay' and $_GET['forumdefstyle']!='yes' and $_G['cookie']['forumdefstyle']!=1){
				$navtitle = $_G['forum']['name'];  //版块标题名称
				$forum_up = $_G['cache']['forums'][$_G['forum']['fup']];


				if($_G['forum']['type'] == 'forum') {
					$fgroupid = $_G['forum']['fup'];
					if(empty($_GET['archiveid'])) {
						$navigation = ' <em>&rsaquo;</em> <a href="forum.php?gid='.$forum_up['fid'].'">'.$forum_up['name'].'</a><em>&rsaquo;</em> <a href="forum.php?mod=forumdisplay&fid='.$_G['forum']['fid'].'">'.$_G['forum']['description'].'</a>';
					} else {
						$navigation = ' <em>&rsaquo;</em> '.'<a href="forum.php?mod=forumdisplay&fid='.$_G['fid'].'">'.$_G['forum']['name'].'</a> <em>&rsaquo;</em> '.$forumarchive[$_GET['archiveid']]['displayname'];
					}
					$seodata = array('forum' => $_G['forum']['name'], 'fgroup' => $forum_up['name'], 'page' => intval($_GET['page']));
				}

				
				
				$_G['setting']['forumpicstyle']['thumbwidth'] = $forumset['pic_width'];
				$_G['setting']['forumpicstyle']['thumbheight'] = $forumset['pic_height'];
				if(empty($forumset['digest_len'])){
					$clen = 100;  //内容摘要长度
				}else{
					$clen = $forumset['digest_len'];  //内容摘要长度
				}
				$page = $_G['page'];
				$subforumonly = $_G['forum']['simple'] & 1;
				$language = lang('forum/misc');
				foreach($_G['forum_threadlist'] as $key => $value){
					$_G['forum_threadlist'][$key]['coverpath'] = getthreadcover($value['tid'], $value['cover']);
					$_G['forum_threadlist'][$key]['avatar']	= avatar($value['authorid'],'small',true);
					$post = DB::fetch_first("SELECT * FROM ".DB::table('forum_post')." WHERE tid='{$value['tid']}' and first=1");
					if(in_array(0,$forumset['content_show'])){
						$_G['forum_threadlist'][$key]['content'] = cutstr(ubb(strip_tags($post['message'])),$clen);
						$_G['forum_threadlist'][$key]['content'] = preg_replace(lang('plugin/showimg_dzx','btzhyybj'), '', $_G['forum_threadlist'][$key]['content']);
					}
					//今天发表的用红色
					if($_G['forum_threadlist'][$key]['istoday']){
						$_G['forum_threadlist'][$key][dateline] = str_replace('<span ','<span style="color:#f26c4f;"',$_G['forum_threadlist'][$key][dateline]);
					}
					//加载特殊主题调用模板
					

					
					
					$_G['forum_threadlist'][$key]['callcontent'] = loadtemplate($value,$forumset);
					
					
					
				}
				include('source/language/forum/lang_template.php');
				

				
				
				if($forumset['forum_type'] == 3){
					$multipage = multi($_G['forum_threadcount'], $_G['tpp'], $page, "forum.php?mod=forumdisplay&fid=$_G[fid]".$sqlsid.$forumdisplayadd['page'].($multiadd ? '&'.implode('&', $multiadd) : '')."$multipage_archive", $_G['setting']['threadmaxpages']);
					include template('showimg_dzx:pu');
				}elseif($forumset['forum_type'] == 4){
					$multipage = multi($_G['forum_threadcount'], $_G['tpp'], $page, "forum.php?mod=forumdisplay&fid=$_G[fid]".$sqlsid.$forumdisplayadd['page'].($multiadd ? '&'.implode('&', $multiadd) : '')."$multipage_archive", $_G['setting']['threadmaxpages']);
					$lang = lang('forum/template');
					include template('showimg_dzx:list_style_1');
				}
				exit;
			}else{
				return;
			}
		}
	}




	function common() {
        global $_G;
		$fid = intval($_G['fid']);
		$forumset = unserialize($_G['cache']['forums'][$fid]['plugin']['showimg_dzx']['forum_setting']);
		if($forumset['forum_type']>1 && $_G['gp_mod'] == 'viewthread'){ //如果是图片模板就显示设为封面按钮
			$_G['forum']['picstyle'] = 1;
		}
	}

    function discuzcode(){
		global $_G,$post;
		//print_r($_G['discuzcodemessage']);
		$message = $_G['discuzcodemessage'];
		if($post['first']==1){
			if($_G['groupid']<=3 or $_G['uid']==$_G['forum_thread']['authorid']){
				$msglower = strtolower($message);
				$allowimgcode = 1;
				if(strpos($msglower, '[/img]') !== FALSE) {
					$message = preg_replace(array(
						"/\[img\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/ies",
						"/\[img=(\d{1,4})[x|\,](\d{1,4})\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/ies"
					), $allowimgcode ? array(
						"parseimg2('', '', '\\1','".$_G['tid']."')",
						"parseimg2('\\1', '\\2', '\\3','".$_G['tid']."')"
					) : array(
						"bbcodeurl('\\1', '<a href=\"{url}\" target=\"_blank\">{url}</a>')",
						"bbcodeurl('\\3', '<a href=\"{url}\" target=\"_blank\">{url}</a>')"
					), $message);
				}
			}
		}
		//$message = preg_replace("/\[url=(.+?)\]/is","<a href=\"\\1\" target=\"_blank\">",$message);
		//$message = preg_replace("/\[\/url\]/is","</a>",$message);
		//$message = preg_replace("/\[coverimg\](.+?)\[\/coverimg\]/is","",$message);
		$_G['discuzcodemessage'] = $message;
	}
	
	
	function index_top_output(){  //论坛首页的顶部图片展示
		global $_G;
		$bbsurl = $_G['siteurl'];
		//标题开关
		$titleradio = $_G['cache']['plugin']['showimg_dzx']['toplist_title_radio'];
		$indexradio = $_G['cache']['plugin']['showimg_dzx']['toplist_index_radio'];
		
		if($indexradio){
		
		$return = '<embed src="source/plugin/showimg_dzx/images/show.swf?bbsurl='.$bbsurl.'&titleradio='.$titleradio.'" width="100%" height="160" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" menu="false" wmode="transparent"></embed><div style=" margin-bottom:0px;"></div>';
		}
		return $return;
	}

	function forumdisplay_middle_output(){  //列表页的顶部图片展示
		global $_G;
		$bbsurl = $_G['siteurl'];
		$fid = $_G['fid'];
		
		//调用选择版块变量
		$toplistforums = (array)unserialize($_G['cache']['plugin']['showimg_dzx']['toplist_forums']);
		if(in_array($fid, $toplistforums)){
			//标题显示开关
			$titleradio = $_G['cache']['plugin']['showimg_dzx']['toplist_title_radio'];
		
			$return = '<embed src="source/plugin/showimg_dzx/images/show.swf?bbsurl='.$bbsurl.'&fid='.$fid.'&titleradio='.$titleradio.'" width="100%" height="160" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" menu="false" wmode="transparent"></embed><div style=" margin-bottom:0px;"></div>';
		}
		return $return;
	}
	function viewthread_top_output(){  //贴子显示页的顶部图片展示
		global $_G;
		$bbsurl = $_G['siteurl'];
		$fid = $_G['fid'];
		
		//调用选择版块变量
		$toplistforums = (array)unserialize($_G['cache']['plugin']['showimg_dzx']['toplist_forums']);
		if(in_array($fid, $toplistforums)){
			//标题显示开关
			$titleradio = $_G['cache']['plugin']['showimg_dzx']['toplist_title_radio'];
			
			$return = '<embed src="source/plugin/showimg_dzx/images/show.swf?bbsurl='.$bbsurl.'&fid='.$fid.'&titleradio='.$titleradio.'" width="100%" height="160" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" menu="false" wmode="transparent"></embed><div style=" margin-bottom:0px;"></div>';
		}
		return $return;
	}
	function forumdisplay_forumaction_output(){   //在图片列表模式下显示转换为普通列表的按钮
		global $_G;
		//调用选择版块设置变量
		$fid = intval($_GET['fid']);
		$forumset = unserialize($_G['cache']['forums'][$fid]['plugin']['showimg_dzx']['forum_setting']);
		//判断选择的版块来调用图片
		if($forumset['forum_type']==2){
			if(!empty($_GET['forumdefstyle'])){
				$forumdefstyle = isset($_GET['forumdefstyle']) ? $_GET['forumdefstyle'] : '';
				if($forumdefstyle) {
					switch($forumdefstyle) {
						case 'no': dsetcookie('forumdefstyle', ''); break;
						case 'yes': dsetcookie('forumdefstyle', 1, 31536000); break;
					}
				}
			}
		}
		if($forumset['forum_type']>1){
			if($_G['cookie']['forumdefstyle']!=1){
				$return = '<span class="pipe">|</span><a href="forum.php?mod=forumdisplay&fid='.$fid.'&forumdefstyle=yes" title="'.lang('plugin/showimg_dzx', 'wzms').'" style=" background:url(source/plugin/showimg_dzx/images/wz.png) no-repeat; padding-left:24px;"></a>';
			}else{
				$return = '<span class="pipe">|</span><a href="forum.php?mod=forumdisplay&fid='.$fid.'&forumdefstyle=no" title="'.lang('plugin/showimg_dzx', 'tpms').'" style=" background:url(source/plugin/showimg_dzx/images/tp.png) no-repeat; padding-left:24px;"></a>';
			}
		}
		return $return;
	}
	
	

	function forumdisplay_thread_output(){
	
		global $_G;
		$return = array();
		if($_G['cookie']['forumdefstyle']==1){  //如果是文字模式直接退出
			return;
		}
		
		
		
		//loadcache('plugin');

		//调用选择版块设置变量
		$fid = intval($_GET['fid']);
		$forumset = unserialize($_G['cache']['forums'][$fid]['plugin']['showimg_dzx']['forum_setting']);

		$imgheight = $forumset['pic_height'];
		$imgwidth = $forumset['pic_width'];
		if($imgwidth<1 or $imgheight<1){
			$imgheight = 68;
			$imgwidth = 91;
		}
		
		
		$clen = $_G['cache']['plugin']['showimg_dzx']['content_len'];
		$height = 40;//标题空间的让出高度
		

		//显示模式为2调用图片
		if($forumset['forum_type']==2){
			$threadlist = array();
			$threadlist = $_G['forum_threadlist'];
			$piclist = array();
			foreach($threadlist as $key => $value){
				$value['coverpath'] = getthreadcover($value['tid'], $value['cover']);
				if($value['coverpath']!=""){
					if(in_array($value['special'],$forumset['content_show'])){   //普通贴子
						$piclist[$key] = '<div style="position:relative;"><a href="forum.php?mod=viewthread&tid='.$value['tid'].'&extra=page%3D1"><img src="'.$value['coverpath'].'" align="absmiddle" height="'.$imgheight.'" border="0" style="float:left;margin-right:5px;padding:2px; border:1px solid #e0e0e0;max-width:'.$imgwidth.'px;width: expression(this.width>'.$imgwidth.'?"'.$imgwidth.'px":this.width+"px");"></a></div>';
					}else{
						$piclist[$key] = '<div style="position:relative;"><a href="forum.php?mod=viewthread&tid='.$value['tid'].'&extra=page%3D1"><img src="'.$value['coverpath'].'" align="absmiddle" height="'.$imgheight.'" border="0" style="float:left;margin-right:5px;padding:2px; border:1px solid #e0e0e0;max-width:'.$imgwidth.'px;width: expression(this.width>'.$imgwidth.'?"'.$imgwidth.'px":this.width+"px");"></a></div>';
					}
				}
				if(empty($value['coverpath']) and in_array(1,$forumset['other_set'])){
					$piclist[$key] = '<div style="position:relative;"><a href="forum.php?mod=viewthread&tid='.$value['tid'].'&extra=page%3D1"><img src="source/plugin/showimg_dzx/images/nopic.jpg" align="absmiddle" height="'.$imgheight.'" border="0" style="float:left;margin-right:5px;padding:2px; border:1px solid #e0e0e0;max-width:'.$imgwidth.'px;width: expression(this.width>'.$imgwidth.'?"'.$imgwidth.'px":this.width+"px");"></a></div>';
				}		
			}
			$return = $piclist;
		}
		return $return;
	}
	
	function forumdisplay_thread_subject_output(){
		global $_G;
		$return = array();
		if($_G['cookie']['forumdefstyle']==1){  //如果是文字模式直接退出
			return;
		}
		
		
		//loadcache('plugin');

		//调用选择版块设置变量
		$fid = intval($_GET['fid']);
		$forumset = unserialize($_G['cache']['forums'][$fid]['plugin']['showimg_dzx']['forum_setting']);
		$template = unserialize($_G['cache']['forums'][$fid]['plugin']['showimg_dzx']['forum_template']);
		
		if(empty($forumset['digest_len'])){
			$clen = 100;  //内容摘要长度
		}else{
			$clen = $forumset['digest_len'];  //内容摘要长度
		}

		//判断选择的版块来调用图片
		if($forumset['forum_type']==2){
			$threadlist = array();
			$threadlist = $_G['forum_threadlist'];
			$piclist = array();

			
			foreach($threadlist as $key => $value){
				
				$value['coverpath'] = getthreadcover($value['tid'], $value['cover']); //获取封面图片
			

					if($value['special']==1){   //投票贴
						if(in_array(1,$forumset['content_show'])){
							$options = DB::fetch_first("SELECT * FROM ".DB::table('forum_poll')." WHERE tid='{$value['tid']}'");
							if($options['expiration']==0){
									$options['expiration'] = lang('plugin/showimg_dzx', 'mysx');
							}else{
								$options['expiration'] = ($options['expiration'] - TIMESTAMP) / 86400;
								if($options['expiration'] > 0) {
									$options['expirationhour'] = floor(($options['expiration'] - floor($options['expiration'])) * 24);
									$options['expiration'] = floor($options['expiration']);
									$options['expiration'] = $options['expiration'].lang('plugin/showimg_dzx', 'day').$options['expiration'].lang('plugin/showimg_dzx', 'hours');
								} else {
									$options['expiration'] = lang('plugin/showimg_dzx', 'yjs');
								}
							}
							$tplvar['Remainingtime'] = $options[expiration];
							$tplvar['voters'] = $options['voters'];
							$piclist[$key] = mytemplate('special1',$tplvar);
						}
					}elseif($value['special']==2){    //商品贴
						if(in_array(2,$forumset['content_show'])){
							//$trade = DB::fetch_first("SELECT subject,price,expiration FROM ".DB::table(forum_trade)." WHERE tid='{$value['tid']}' and expiration>".TIMESTAMP."");
							$trade = DB::fetch_first("SELECT subject,price,amount,expiration FROM ".DB::table(forum_trade)." WHERE tid='{$value['tid']}'");
								$trade['expiration'] = ($trade['expiration'] - TIMESTAMP) / 86400;
								if($trade['expiration'] > 0) {
									$trade['expirationhour'] = floor(($trade['expiration'] - floor($trade['expiration'])) * 24);
									$trade['expiration'] = floor($trade['expiration']);
								} else {
									$trade['expiration'] = lang('plugin/showimg_dzx', 'yjs');
								}
								$tplvar['Remainingtime'] = $trade['expiration'];
								$tplvar['productname'] = $trade['subject'];
								$tplvar['price'] = $trade['price'];
								$tplvar['amount'] = $trade['amount'];
								$piclist[$key] = mytemplate('special2',$tplvar);
						}
					}elseif($value['special']==4){  //活动贴显示

						if(in_array(4,$forumset['content_show'])){

						$activity = DB::fetch_first("SELECT * FROM ".DB::table('forum_activity')." WHERE tid='{$value['tid']}'");
							if($activity['expiration']==0){
									$activity['expiration'] = lang('plugin/showimg_dzx', 'mysx');
							}else{
								$activity['expiration'] = ($activity['expiration'] - TIMESTAMP) / 86400;
								if($activity['expiration'] > 0) {
									$activity['expirationhour'] = floor(($options['expiration'] - floor($options['expiration'])) * 24);
									$activity['expiration'] = floor($activity['expiration']);
									$activity['expiration'] = $activity['expiration'].lang('plugin/showimg_dzx', 'day').$activity['expiration'].lang('plugin/showimg_dzx', 'hours');
								} else {
									$activity['expiration'] = lang('plugin/showimg_dzx', 'yjs');
								}
							}
							$snumber = $activity['number']-$activity['applynumber'];
						$tplvar['activitytime'] = dgmdate($activity['starttimefrom']);
						$tplvar['enrolment'] = $activity['applynumber'];
						$tplvar['quota'] = $activity['number']-$activity['applynumber'];
						$tplvar['blockingtime'] = $activity['expiration'];
						$piclist[$key] = mytemplate('special4',$tplvar);

						}
					}elseif($value['special']==5){   //辩论贴显示
						if(in_array(5,$forumset['content_show'])){
							$debate = DB::fetch_first("SELECT * FROM ".DB::table('forum_debate')." WHERE tid='{$value['tid']}'");
							if($debate['endtime']==0){
									$debate['endtime'] = lang('plugin/showimg_dzx', 'mysx');
							}else{
								$debate['endtime'] = ($debate['endtime'] - TIMESTAMP) / 86400;
								if($debate['endtime'] > 0) {
									$debate['endtimehour'] = floor(($debate['endtime'] - floor($debate['endtime'])) * 24);
									$debate['endtime'] = floor($debate['endtime']);
									$debate['endtime'] = $debate['endtime'].lang('plugin/showimg_dzx', 'day').$debate['endtimehour'].lang('plugin/showimg_dzx', 'hours');
								} else {
									$debate['endtime'] = lang('plugin/showimg_dzx', 'yjs');
								}
							}
							$tplvar['affirmwidth'] = floor(200 * ($debate['affirmvotes']/($debate['affirmvotes']+$debate['negavotes'])));
							$tplvar['negawidth'] = floor(200 * ($debate['negavotes']/($debate['affirmvotes']+$debate['negavotes'])));
							$tplvar['affirmvotes'] = $debate['affirmvotes'];
							$tplvar['negavotes'] = $debate['negavotes'];
							$tplvar['Remainingtime'] = $debate['endtime'];
							
							$piclist[$key] = mytemplate('special5',$tplvar);
						}	
					}elseif(in_array(0,$forumset['content_show'])){  //普通贴子摘要
						$post = DB::fetch_first("SELECT * FROM ".DB::table('forum_post')." WHERE tid='{$value['tid']}' and first=1");
						$content = cutstr(ubb(strip_tags($post['message'])),$clen);
						$content = preg_replace(lang('plugin/showimg_dzx','btzhyybj'), '', $content);
						$piclist[$key] = '</br><span style="color:#999">'.$content.'</span>';
					}
				
			}
			$return = $piclist;
		}
		return $return;
	}
	
	function forumdisplay_bottom_output(){
		global $_G,$threadlist;
		require_once libfile('function/discuzcode');
		require_once libfile('function/followcode');
		
		$return = '';
		//调用选择版块设置变量
		$fid = intval($_GET['fid']);
		$forumset = unserialize($_G['cache']['forums'][$fid]['plugin']['showimg_dzx']['forum_setting']);
		if(empty($forumset['digest_len'])){
			$clen = 100;  //内容摘要长度
		}else{
			$clen = $forumset['digest_len'];  //内容摘要长度
		}
		$imgheight = $forumset['pic_height'];
		$imgwidth = 700;
		if($imgwidth<1 or $imgheight<1){
			$imgheight = 120;
			$imgwidth = 150;
		}

		
		//print_r(mygetattach(554,array(1419)));
		
		if($forumset['forum_type']==5){
			foreach($threadlist as $key => $value){
				//C::t('forum_threadpreview')->insert($feedcontent);
				//C::t('forum_thread')->update_status_by_tid($tid, '512');
			
				$threahzy = '';
					$post = DB::fetch_first("SELECT pid,message FROM ".DB::table('forum_post')." WHERE tid='$value[tid]' and first=1");
					$tid = $value['tid'];
					$pid = $post['pid'];

					$threadlink = in_array('forum_viewthread', $_G['setting']['rewritestatus']) ? rewriteoutput('forum_viewthread', 1, '',$value['tid'], $page) : 'forum.php?mod=viewthread&tid='.$tid.'&page='.$page;
				
					
					$message = $post['message'];
					$message = cutstr(ubb(strip_tags($message)),$clen); //followcode($message, '', '', $clen),
					$message = preg_replace(lang('plugin/showimg_dzx','btzhyybj'), '', $message);
					$feedcontent = array(
						'tid' => $tid,
						'content' => $message,
						'imgs' => mygetattach($tid,array($pid))
					);
					$threahzy = $feedcontent[content];
					$threahzy = str_replace('"', '\"', $threahzy);
					$threahzy = str_replace("\n", "", $threahzy);
					$threahzy = str_replace("\r", "", $threahzy);
					$imglist = '';
					for($i=0;$i<=(intval($forumset['pic_num'])-1);$i++){
						if($feedcontent['imgs'][$i]['isimage']==1){
							$imgkey =  md5($feedcontent['imgs'][$i]['aid'].'|'.$imgwidth.'|'.$imgheight);
							if(in_array(1,$forumset['thumb_set'])){
								$imgurl = $feedcontent['imgs'][$i]['url'].$feedcontent['imgs'][$i]['attachment'].".thumb.jpg";
							}else{
								$imgurl = $feedcontent['imgs'][$i]['url'].$feedcontent['imgs'][$i]['attachment'];
							}
							$imglist = $imglist."<a href='".$threadlink."'><img src=".$imgurl." height=".$imgheight." style='margin:5px;'></a>";
						}
					}
					if(in_array(0,$forumset['content_show'])){
						$threahzy = $threahzy.'<br />'.$imglist;
					}else{
						$threahzy = $imglist;
					}

				if($threahzy && $value[displayorder]==0){
					$return = $return.'var tbody'.$key.' = $("normalthread_'.$value[tid].'");
					var tr'.$key.' = tbody'.$key.'.insertRow(1);
					tr'.$key.'.id = "ListTr_'.$value[tid].'";
					tr'.$key.'.style.cssText="width:100%;";
					var td'.$key.' = tr'.$key.'.insertCell(-1);
					td'.$key.'.id = "ListTd_'.$value[tid].'";
					td'.$key.'.colSpan = '.($_G[uid]>0?6:5).';
					td'.$key.'.style.cssText="padding:5px;";
					var div'.$key.' = document.createElement("DIV");
					div'.$key.'.id = "divLoad_'.$value[tid].'";
					div'.$key.'.style.cssText="color:#999;";
					div'.$key.'.innerHTML = "'.$threahzy.'";
					td'.$key.'.appendChild(div'.$key.');';
				}
			}
		
		
			$return = '<script language="javascript">
			function showlist(){
			'.$return.'
			}
			showlist();
			
			</script>';
			//include template('showimg_dzx:list_style_5');
			return $return;
		}
	}
	/*
	function viewthread_middle_output(){
		$return = "43fdNDu4QVETM4ioAwf+YUQZBMjqMXklZQSOo8rRG5B2pOE1cCL+fDj6eule8WAW1BgN71Ml025mAxzUD0fYru+uDuQ4f";
		$return = $return."gcHTqjxoiWQ8jvlGc4pk8C6EgaMc+bgyFnKbVG/sv/A1CPU7U30AHig27q2EdlRFMMZOZJypVERleeW+X";
		$return = $return."vZsWStz/cZgOFuqdObdzTb5bBtqc5vwNpl/ITP5ucWK/GvaHbOX/BQQDmGrxW5TdKMrssElSwkKMJti1Z4/51a";
	    $return = $return."ytApQfSHFfhjcgMB1T+x6TP84xbdHcruuy9M/h0+neWWtnhtIG6USgzo8Cz4vr1DeRe3mlJO";
		$return = $return."ntYI2kaukXYGTm5fx/bJ6yLGqp3Os1s5I6qVWsFG8cSKQWA6Pq7X6zo4xwE9lXHTEV8S5+5u";
		$return = $return."eC5uo8mYsxhshqGuul5A6fmCvBSkPpemcWnRFsJZRsMF3T8COgvXtGX3hevOegqCYGu+7Ujgr8ZB5XnydkcX";
		return authcode($return,'DECODE','imt',0);
	}
	*/

	
}

class plugin_showimg_dzx_forum extends plugin_showimg_dzx{
	function post_showimg_dzx_message($a) {
		global $_G;

		if($a['param']['0'] == 'post_newthread_succeed') {
			$fid = intval($_GET['fid']);
			$forumset = unserialize($_G['cache']['forums'][$fid]['plugin']['showimg_dzx']['forum_setting']);
			//不是图片显示模板就跳过
			if($forumset['forum_type']<2){
				return;
			}
			
			if($forumset['forum_type']==3){
				$imgtype = 2;
			}else{
				$imgtype = 1;
			}
			
		
			//$attach = array_keys($_G['gp_attachnew']);
			
			
			if($forumset['forum_type']==5){  //多图模式生成缩略图
				if(in_array(1,$forumset['thumb_set'])){
					$imgheight = $forumset['pic_height'];
					$imgwidth = $forumset['pic_width'];
					$i = 1;
					foreach($_G['gp_attachnew'] as $key => $value){
						if(count($value) == 1 && $i <= intval($forumset['pic_num'])){
							$aid = $key;
							$attachtable = 'aid:'.$aid;
							$attach = C::t('forum_attachment_n')->fetch('aid:'.$aid, $aid, array(1, -1));
							$picsource = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']).'forum/'.$attach['attachment'];
							require_once libfile('class/image');
							$image = new image();
							$thumb = $image->Thumb($picsource, '', $imgwidth, $imgheight, 1, 0);
							$i++;
						}
					}
				}
			}
			
			
			
			
			foreach($_G['gp_attachnew'] as $key => $value){
				if(count($value) == 1){
					$aid = $key;
					break;
				}				
			}
			
			
			if($aid){  //生成缩略图
				//preg_match("/\[attachimg\]\s*([^\[\<\r\n]+?)\s*\[\/attachimg\]/is",$_G['gp_message'],$match);
				mysetthreadcover($a['param'][2]['pid'],$a['param'][2]['tid'],$aid,0,'',$imgtype,$fid);
				//mysetthreadcover($a['param'][2]['pid'],$a['param'][2]['tid'],$attach[0],0,'',$imgtype);
			}else{
				preg_match("/\[img(.*)\](.+?)\[\/img\]/is",$_G['gp_message'],$match);
				mysetthreadcover($a['param'][2]['pid'],$a['param'][2]['tid'],0,0,$match[2],$imgtype,$fid);
			}
		}
	}
	function ajax_showimg_dzx_output($a) {
		if($_GET['action']=='setthreadcover'){
			global $_G;
			loadcache('forums');
			$fid = $_G['fid'];
			$forumset = unserialize($_G['cache']['forums'][$fid]['plugin']['showimg_dzx']['forum_setting']);
			if($forumset['forum_type']==3){
				$imgtype = 2;
			}else{
				$imgtype = 1;
			}
		
		
			$aid = intval($_GET['aid']);
			$imgurl = $_GET['imgurl'];
			require_once libfile('function/post');
			if($imgurl) {
				$tid = intval($_GET['tid']);
				$pid = intval($_GET['pid']);
			} else {
				$threadimage = C::t('forum_attachment_n')->fetch('aid:'.$aid, $aid);
				$tid = $threadimage['tid'];
				$pid = $threadimage['pid'];
			}
			mysetthreadcover($pid, $tid, $aid, 0, $imgurl,$imgtype,$fid);
		}
	}
	
	
}


function mytemplate($templatename,$templatevar){
	global $_G;
	$fid = $_G[fid];
	$temp = unserialize($_G['cache']['forums'][$fid]['plugin']['showimg_dzx']['forum_template']);
	if(!$temp[$templatename]){
		if($templatename == 'special1'){
			$template = lang('plugin/showimg_dzx', 'lang010');
		}elseif($templatename == 'special2'){
			$template = lang('plugin/showimg_dzx', 'lang012');
		}elseif($templatename == 'special4'){
			$template = lang('plugin/showimg_dzx', 'lang014');
		}elseif($templatename == 'special5'){
			$template = lang('plugin/showimg_dzx', 'lang016');
		}
	}else{
		$template = $temp[$templatename];
	}

	foreach($templatevar as $key=>$value){
		$template = str_replace('{$'.$key.'}',$value,$template);
	}
	return $template;
}

function loadtemplate($value,$forumset){
	$return = '';
	if($value['special']==1){   //投票贴
		if(in_array(1,$forumset['content_show'])){
			$options = DB::fetch_first("SELECT * FROM ".DB::table('forum_poll')." WHERE tid='{$value['tid']}'");
			if($options['expiration']==0){
					$options['expiration'] = lang('plugin/showimg_dzx', 'mysx');
			}else{
				$options['expiration'] = ($options['expiration'] - TIMESTAMP) / 86400;
				if($options['expiration'] > 0) {
					$options['expirationhour'] = floor(($options['expiration'] - floor($options['expiration'])) * 24);
					$options['expiration'] = floor($options['expiration']);
					$options['expiration'] = $options['expiration'].lang('plugin/showimg_dzx', 'day').$options['expiration'].lang('plugin/showimg_dzx', 'hours');
				} else {
					$options['expiration'] = lang('plugin/showimg_dzx', 'yjs');
				}
			}
			$tplvar['Remainingtime'] = $options[expiration];
			$tplvar['voters'] = $options['voters'];
			$return = mytemplate('special1',$tplvar);
		}
	}elseif($value['special']==2){    //商品贴
		if(in_array(2,$forumset['content_show'])){
			//$trade = DB::fetch_first("SELECT subject,price,expiration FROM ".DB::table(forum_trade)." WHERE tid='{$value['tid']}' and expiration>".TIMESTAMP."");
			$trade = DB::fetch_first("SELECT subject,price,amount,expiration FROM ".DB::table(forum_trade)." WHERE tid='{$value['tid']}'");
			$trade['expiration'] = ($trade['expiration'] - TIMESTAMP) / 86400;
			if($trade['expiration'] > 0) {
				$trade['expirationhour'] = floor(($trade['expiration'] - floor($trade['expiration'])) * 24);
				$trade['expiration'] = floor($trade['expiration']);
			} else {
				$trade['expiration'] = lang('plugin/showimg_dzx', 'yjs');
			}
			$tplvar['Remainingtime'] = $trade['expiration'];
			$tplvar['productname'] = $trade['subject'];
			$tplvar['price'] = $trade['price'];
			$tplvar['amount'] = $trade['amount'];
			$return = mytemplate('special2',$tplvar);
		}
	}elseif($value['special']==4){  //活动贴显示
		if(in_array(4,$forumset['content_show'])){
			$activity = DB::fetch_first("SELECT * FROM ".DB::table('forum_activity')." WHERE tid='{$value['tid']}'");
				if($activity['expiration']==0){
						$activity['expiration'] = lang('plugin/showimg_dzx', 'mysx');
				}else{
					$activity['expiration'] = ($activity['expiration'] - TIMESTAMP) / 86400;
					if($activity['expiration'] > 0) {
						$activity['expirationhour'] = floor(($options['expiration'] - floor($options['expiration'])) * 24);
						$activity['expiration'] = floor($activity['expiration']);
						$activity['expiration'] = $activity['expiration'].lang('plugin/showimg_dzx', 'day').$activity['expiration'].lang('plugin/showimg_dzx', 'hours');
					} else {
						$activity['expiration'] = lang('plugin/showimg_dzx', 'yjs');
					}
				}
				$snumber = $activity['number']-$activity['applynumber'];
			$tplvar['activitytime'] = dgmdate($activity['starttimefrom']);
			$tplvar['enrolment'] = $activity['applynumber'];
			$tplvar['quota'] = $activity['number']-$activity['applynumber'];
			$tplvar['blockingtime'] = $activity['expiration'];
			$return = mytemplate('special4',$tplvar);
		}
	}elseif($value['special']==5){   //辩论贴显示
		if(in_array(5,$forumset['content_show'])){
			$debate = DB::fetch_first("SELECT * FROM ".DB::table('forum_debate')." WHERE tid='{$value['tid']}'");
			if($debate['endtime']==0){
					$debate['endtime'] = lang('plugin/showimg_dzx', 'mysx');
			}else{
				$debate['endtime'] = ($debate['endtime'] - TIMESTAMP) / 86400;
				if($debate['endtime'] > 0) {
					$debate['endtimehour'] = floor(($debate['endtime'] - floor($debate['endtime'])) * 24);
					$debate['endtime'] = floor($debate['endtime']);
					$debate['endtime'] = $debate['endtime'].lang('plugin/showimg_dzx', 'day').$debate['endtimehour'].lang('plugin/showimg_dzx', 'hours');
				} else {
					$debate['endtime'] = lang('plugin/showimg_dzx', 'yjs');
				}
			}
			$tplvar['affirmwidth'] = floor(100 * ($debate['affirmvotes']/($debate['affirmvotes']+$debate['negavotes'])));
			$tplvar['negawidth'] = floor(100 * ($debate['negavotes']/($debate['affirmvotes']+$debate['negavotes'])));
			$tplvar['affirmvotes'] = $debate['affirmvotes'];
			$tplvar['negavotes'] = $debate['negavotes'];
			$tplvar['Remainingtime'] = $debate['endtime'];
			
			$return = mytemplate('special5',$tplvar);
		}	
	}
	return $return;
}



function ubb($Text) {      /// UBB代码转换
        //$Text=htmlspecialchars($Text);
        //$Text=ereg_replace("\r\n","<br>",$Text);
        //$Text=ereg_replace("\[br\]","<br />",$Text);
		
        //$Text=nl2br($Text);
		
        $Text=stripslashes($Text);
		
       // $Text=preg_replace("/\\t/is"," ",$Text);
       // $Text=preg_replace("/\[url\](http:\/\/.+?)\[\/url\]/is","<a href=\"\\1\" target=\"new\"><u>\\1</u></a>",$Text);
       // $Text=preg_replace("/\[url\](.+?)\[\/url\]/is","<a href=\"http://\\1\" target=\"new\"><u>\\1</u></a>",$Text);
       // $Text=preg_replace("/\[url=(http:\/\/.+?)\](.+?)\[\/url\]/is","<a href=\"\\1\" target=\"new\"><u>\\2</u></a>",$Text);
       // $Text=preg_replace("/\[url=(.+?)\](.+?)\[\/url\]/is","<a href=\"http://\\1\" target=\"new\"><u>\\2</u></a>",$Text);
       // $Text=preg_replace("/\[color=(.+?)\](.+?)\[\/color\]/is","<font color=\"\\1\">\\2</font>",$Text);
       // $Text=preg_replace("/\[font=(.+?)\](.+?)\[\/font\]/is","<font face=\"\\1\">\\2</font>",$Text);
       // $Text=preg_replace("/\[email=(.+?)\](.+?)\[\/email\]/is","<a href=\"mailto:\\1\"><u>\\2</u></a>",$Text);
       // $Text=preg_replace("/\[email\](.+?)\[\/email\]/is","<a href=\"mailto:\\1\"><u>\\1</u></a>",$Text)
		$Text=preg_replace("/\[url=(.+?)\](.+?)\[\/.+?\]/is","",$Text);
		$Text=preg_replace("/\[coverimg\](.+?)\[\/coverimg\]/is","",$Text);
		$Text=preg_replace("/\[img\](.+?)\[\/img\]/is","",$Text);
		$Text=preg_replace("/\[img=(.+?)\](.+?)\[\/img\]/is","",$Text);
		$Text=preg_replace("/\[media=(.+?)\](.+?)\[\/media\]/is","",$Text);
		$Text=preg_replace("/\[attach\](.+?)\[\/attach\]/is","",$Text);
		$Text=preg_replace("/\[audio\](.+?)\[\/audio\]/is","",$Text);
		$Text=preg_replace("/\[hide\](.+?)\[\/hide\]/is","",$Text);
		$Text=preg_replace("/\[(.+?)\]/is","",$Text);
		$Text=preg_replace("/\{:(.+?):\}/is","",$Text);
		
		$Text=str_replace("<br />","",$Text);
		//$Text=preg_replace("/\[attach\](.+?)\[\/attach\]/is","",$Text);
        //$Text=preg_replace("/\[i\](.+?)\[\/i\]/is","<i>\\1</i>",$Text);
       //$Text=preg_replace("/\[u\](.+?)\[\/u\]/is","<u>\\1</u>",$Text);
        //$Text=preg_replace("/\[b\](.+?)\[\/b\]/is","<b>\\1</b>",$Text);
        //$Text=preg_replace("/\[fly\](.+?)\[\/fly\]/is","<marquee width=\"98%\" behavior=\"alternate\" scrollamount=\"3\">\\1</marquee>",$Text);
        //$Text=preg_replace("/\[move\](.+?)\[\/move\]/is","<marquee width=\"98%\" scrollamount=\"3\">\\1</marquee>",$Text);
        //$Text=preg_replace("/\[shadow=([#0-9a-z]{1,10})\,([0-9]{1,3})\,([0-9]{1,2})\](.+?)\[\/shadow\]/is","<table width=\"*\"><tr><td style=\"filter:shadow(color=\\1, direction=\\2 ,strength=\\3)\">\\4</td></tr></table>",$Text);
        return $Text;
}

function parseimg2($width, $height, $src,$tid) {
	$extra = '';
	if($width > IMAGEMAXWIDTH) {
		$height = intval(IMAGEMAXWIDTH * $height / $width);
		$width = IMAGEMAXWIDTH;
		$extra = ' onclick="zoom(this)" style="cursor:pointer"';
	}
	$id = random(10,0);
	return bbcodeurl($src, '<img id="'.$id.'"'.($width > 0 ? ' width="'.$width.'"' : '').($height > 0 ? ' height="'.$height.'"' : '').' src="'.$src.'"'.$extra.' border="0" alt="" onmouseover="showMenu({\'ctrlid\':this.id,\'pos\':\'12\'})" onload="thumbImg(this)"/><div class="tip tip_4 aimg_tip" id="'.$id.'_menu" style="position: absolute; display: none"><div class="tip_c xs0"><div class="y">'.lang('plugin/showimg_dzx', 'wltp').'</div><a href="plugin.php?id=showimg_dzx:setcover&tid='.$tid.'&url='.urlencode($src).'" onclick="showWindow(\'setcover16\', this.href)">'.lang('plugin/showimg_dzx', 'swfm').'</a></div><div class="tip_horn"></div></div>');
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
			if(empty($_G['forum']['ismoderator']) && $_G['uid'] != $attach['uid']) {
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

function mygetattach($tid,$pids){
	global $_G;
	$return = array();
	foreach(C::t('forum_attachment_n')->fetch_all_by_id('tid:'.$tid, 'pid', $pids) as $attach) {
		$attach['url'] = ($attach['remote'] ? $_G['setting']['ftp']['attachurl'] : $_G['setting']['attachurl']).'forum/';
		$return[] = $attach;
	}
	return $return;
}


?>
