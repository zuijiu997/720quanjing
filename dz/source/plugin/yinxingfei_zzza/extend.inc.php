<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require_once DISCUZ_ROOT.'./source/plugin/yinxingfei_zzza/zzza_version.php';
if($_GET['caozuo'] == 'anzhuang'){
	$extend_lang = @include DISCUZ_ROOT.'./source/plugin/yinxingfei_zzza/extend/'.$_GET['file'].'/extend_lang/'.currentlang().'.php';
	$post['name'] = $extend_lang['name'];
	$post['identifier'] = $extend_lang['identifier'];
	$post['version'] = $extend_lang['version'];
	$post['copyright'] = $extend_lang['copyright'];
	$post['description'] = $extend_lang['description'];
	$post['menu'] = $extend_lang['menu'];
	$post['available'] = '0';
	foreach($post as $key => $value){
		$post[$key] = daddslashes($value);
	}
	$ifcz = DB::result_first("SELECT COUNT(*) FROM ".DB::table('yinxingfei_zzza_kuozhan')." WHERE identifier = '".$post['identifier']."'");
	if($ifcz > 0){
		cpmsg(lang("plugin/yinxingfei_zzza","tz_1").'"'.$post['identifier'].'"'.lang("plugin/yinxingfei_zzza","tz_2"), 'action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=extend','error');
	}else{
		DB::insert('yinxingfei_zzza_kuozhan', $post);
		cpmsg(lang("plugin/yinxingfei_zzza","tz_3"), 'action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=extend','succeed');
	}
}elseif($_GET['caozuo'] == 'guanbi'){
	DB::query("UPDATE ".DB::table('yinxingfei_zzza_kuozhan')." SET available = '0' WHERE kzid= '".$_GET['kzid']."'", 'UNBUFFERED');
	cpmsg(lang("plugin/yinxingfei_zzza","tz_4"), 'action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=extend','succeed');
}elseif($_GET['caozuo'] == 'xiezai'){
	DB::query("DELETE FROM ".DB::table('yinxingfei_zzza_kuozhan')." WHERE kzid = '".$_GET['kzid']."'");
	cpmsg(lang("plugin/yinxingfei_zzza","tz_5"), 'action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=extend','succeed');
}elseif($_GET['caozuo'] == 'kaiqi'){
	DB::query("UPDATE ".DB::table('yinxingfei_zzza_kuozhan')." SET available = '1' WHERE kzid= '".$_GET['kzid']."'", 'UNBUFFERED');
	cpmsg(lang("plugin/yinxingfei_zzza","tz_6"), 'action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=extend','succeed');
}elseif($_GET['caozuo'] == 'extend'){
	$ifcz = DB::result_first("SELECT COUNT(*) FROM ".DB::table('yinxingfei_zzza_kuozhan')." WHERE identifier = '".$_GET['file']."' AND available = '1'");
	if($ifcz > 0){
		$extend_lang = @include DISCUZ_ROOT.'./source/plugin/yinxingfei_zzza/extend/'.$_GET['file'].'/extend_lang/'.currentlang().'.php';
		include DISCUZ_ROOT.'./source/plugin/yinxingfei_zzza/extend/'.$_GET['file'].'/'.$_GET['file'].'.extend.php';
	}else{
		cpmsg(lang("plugin/yinxingfei_zzza","tz_7"), 'action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=extend','error');
	}
}else{
	//已开启
	showtableheader();
	showtagheader('tbody class="psetting"', '', true);
	showtitle(lang("plugin/yinxingfei_zzza","tz_8"));
	$sql = "SELECT * FROM ".DB::table('yinxingfei_zzza_kuozhan')." WHERE available = '1' ORDER BY identifier ASC";
	$query = DB::query($sql);
	while($result = DB::fetch($query)){
		
			$menu_t = '';
			$menu = explode(",",$result['menu']);
			if(count($menu) == 1){
				$menu_t .= '<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=extend&caozuo=extend&file='.$result['identifier'].'">'.$result['menu'].'</a>&nbsp;&nbsp;';
			}else{
				foreach($menu as $v){
					$vr = explode("-",$v);
					if(count($vr ) == 1){
						$menu_t .= '<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=extend&caozuo=extend&file='.$result['identifier'].'&ac='.$v.'">'.$v.'</a>&nbsp;&nbsp;';
					}else{
						$va = $vr[0];
						$vb = $vr[1];
						$menu_t .= '<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=extend&&caozuo=extend&file='.$result['identifier'].'&ac='.$va.'">'.$vb.'</a>&nbsp;&nbsp;';
					}
				}
			}
			if($menu_t && $result['name']){
				showtablerow('class="hover hover" style="overflow: hidden;"', array(), array(
						'<div style="float:left;width:20%;padding-bottom: 10px;">
							<p><strong>'.$result['name'].'</strong></p>
							<p>'.$menu_t.'</p></div>
						<div style="float:left;width:80%;padding-bottom: 10px;">
							<p>'.lang("plugin/yinxingfei_zzza","tz_9").$result['description'].'</p>
							<p style="overflow: hidden;">
								<div style="float:left;width:50%;">'.$result['version'].''.lang("plugin/yinxingfei_zzza","tz_10").' <em style="color:#ddd;">|</em> '.lang("plugin/yinxingfei_zzza","tz_11").' '.$result['copyright'].' <em style="color:#ddd;">|</em> '.lang("plugin/yinxingfei_zzza","tz_12").' '.$result['identifier'].' </div><div style="text-align: right;float:right;width:50%;"><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=extend&caozuo=guanbi&kzid='.$result['kzid'].'">'.lang("plugin/yinxingfei_zzza","tz_13").'</a>&nbsp;&nbsp;<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=extend&caozuo=xiezai&kzid='.$result['kzid'].'">'.lang("plugin/yinxingfei_zzza","tz_14").'</a></div>
							</p>
						</div>'
				));
				echo '<style>.yincang_'.$result['identifier'].' {display:none;}</style>';
			}
	}
	showtagfooter('tbody');
	//关闭
	showtableheader();
	showtagheader('tbody class="psetting"', '', true);
	showtitle(lang("plugin/yinxingfei_zzza","tz_15"));
	$sql = "SELECT * FROM ".DB::table('yinxingfei_zzza_kuozhan')." WHERE available = '0' ORDER BY identifier ASC";
	$query = DB::query($sql);
	while($result = DB::fetch($query)){
		
			if($result['name']){
				showtablerow('class="hover hover" style="overflow: hidden;"', array(), array(
						'<div style="float:left;width:20%;padding-bottom: 10px;">
							<p><strong>'.$result['name'].'</strong></p>
							<p>&nbsp;</p></div>
						<div style="float:left;width:80%;padding-bottom: 10px;">
							<p>'.lang("plugin/yinxingfei_zzza","tz_9").''.$result['description'].'</p>
							<p style="overflow: hidden;">
								<div style="float:left;width:50%;">'.$result['version'].''.lang("plugin/yinxingfei_zzza","tz_10").' <em style="color:#ddd;">|</em> '.lang("plugin/yinxingfei_zzza","tz_11").' '.$result['copyright'].' <em style="color:#ddd;">|</em> '.lang("plugin/yinxingfei_zzza","tz_12").' '.$result['identifier'].' </div><div style="text-align: right;float:right;width:50%;"><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=extend&caozuo=kaiqi&kzid='.$result['kzid'].'">'.lang("plugin/yinxingfei_zzza","tz_17").'</a>&nbsp;&nbsp;<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=extend&caozuo=xiezai&kzid='.$result['kzid'].'">'.lang("plugin/yinxingfei_zzza","tz_14").'</a></div>
							</p>
						</div>'
				));
				echo '<style>.yincang_'.$result['identifier'].' {display:none;}</style>';
			}
	}
	//未安装
	$dir = DISCUZ_ROOT.'./source/plugin/yinxingfei_zzza/extend/';
	showtableheader();
	showtagheader('tbody class="psetting"', '', true);
	showtitle(lang("plugin/yinxingfei_zzza","tz_16"));
	$extend =  get_extend($dir);
	$extend = array_filter($extend);
	foreach($extend as $key => $value){
		if($value['name']){
			showtablerow('class="hover hover yincang_'.$value['identifier'].'" style="overflow: hidden;"', array(), array(
					'<div style="float:left;width:20%;padding-bottom: 10px;">
						<p><strong>'.$value['name'].'</strong></p>
						<p>&nbsp;</p></div>
					<div style="float:left;width:80%;padding-bottom: 10px;">
						<p>'.lang("plugin/yinxingfei_zzza","tz_9").''.$value['description'].'</p>
						<p style="overflow: hidden;">
							<div style="float:left;width:50%;">'.$value['version'].''.lang("plugin/yinxingfei_zzza","tz_10").' <em style="color:#ddd;">|</em> '.lang("plugin/yinxingfei_zzza","tz_11").' '.$value['copyright'].' <em style="color:#ddd;">|</em> '.lang("plugin/yinxingfei_zzza","tz_12").' '.$value['identifier'].' </div><div style="text-align: right;float:right;width:50%;"><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=extend&caozuo=anzhuang&file='.$value['file'].'">'.lang("plugin/yinxingfei_zzza","tz_18").'</a></div>
						</p>
					</div>'
			));
		}
	}
	showtagfooter('tbody');
	showtablefooter();
}
function get_extend($dir){
	$tree = array();
	if (is_dir($dir)){
		if ($dh = opendir($dir)){
			while (($file = readdir($dh))!= false){
				if( $file != "." && $file != ".." ){
					$extend_lang = @include DISCUZ_ROOT.'./source/plugin/yinxingfei_zzza/extend/'.$file.'/extend_lang/'.currentlang().'.php';
					$tree[$file]['file'] = $file;
					$tree[$file]['name'] = $extend_lang['name'];
					$tree[$file]['identifier'] = $extend_lang['identifier'];
					$tree[$file]['version'] = $extend_lang['version'];
					$tree[$file]['copyright'] = $extend_lang['copyright'];
					$tree[$file]['description'] = $extend_lang['description'];
					$tree[$file]['menu'] = $extend_lang['menu'];
				}
			}
			closedir($dh);
		}
	}
	return $tree;
}
?>