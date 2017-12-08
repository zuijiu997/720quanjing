<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
	if(submitcheck('backup')){
		if(preg_match('/[^A-Za-z0-9_]/', $_GET['filename'])){
			cpmsg(lang("plugin/yinxingfei_zzza","x"));
		}
		$file = DISCUZ_ROOT."./data/zzza_backup/[".ZZZA_VERSION."]-[".date("Ymd")."]-".$_GET['filename'].".vbak";
		@touch($file);
		if(!is_writeable($file)) cpmsg(lang("plugin/yinxingfei_zzza","x1"));
		$out_arr = zhdata($_POST['db_sel']);
		if($_POST['shezhi']){
			//设置备份
			$query = DB::query('SELECT variable,value,pluginid FROM '.DB::table('common_pluginvar').' WHERE pluginid = \''.$pluginid.'\'');
			while($data = DB::fetch($query)){
				$out_arr['shezhi'][] = $data;
			}
		}
		$output = serialize($out_arr);
		file_put_contents($file, $output);
		cpmsg(lang("plugin/yinxingfei_zzza","x2"), "action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=extend&caozuo=extend&file=sjbf", 'succeed');
		dexit();
	}elseif(submitcheck('restore', 1)){
		$file = DISCUZ_ROOT."./data/zzza_backup/{$_GET[filename]}";
		if(!file_exists($file)) cpmsg(lang("plugin/yinxingfei_zzza","x3"));
		$filer = explode("-",$_GET['filename']);
		$banben = trim($filer[count($filer)-3]);
		if($banben != trim('['.ZZZA_VERSION.']')){
			cpmsg($extend_lang['bbbyz'],'','error');
		}
		$data_str = file_get_contents($file);
		$data = unserialize($data_str);
		
		foreach($data as $key => $value){
			if($key != 'shezhi'){
				hfdata($data[$key],$key);
			}else{//恢复插件设置
				hfshezhi($data[$key],$key);
			}
		}
		require_once libfile('function/cache');
		updatecache('yinxingfei_zzza');
		cpmsg(lang("plugin/yinxingfei_zzza","x4"), "action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=extend&caozuo=extend&file=sjbf", 'succeed');
		dexit();
	}
	$zzza_db = @include DISCUZ_ROOT.'./source/plugin/yinxingfei_zzza/zzza_db.php';
	showtableheader(lang("plugin/yinxingfei_zzza","x5"));
	showformheader("plugins&operation=config&identifier=yinxingfei_zzza&pmod=extend&caozuo=extend&file=sjbf");
	$selected .= '<li style="float: none;height: 25px;" class="checked"><input class="checkbox" type="checkbox" name="shezhi" value="1" checked>'.$extend_lang['lang_1'].'</li>';
	
	foreach($zzza_db as $key => $value){
		$selected .= '<li style="float: none;height: 25px;" class="checked"><input class="checkbox" type="checkbox" name="db_sel[]" value="'.$key.'" checked>'.$extend_lang['lang_2'].''.$key.'</li>';
	}
	showsetting($extend_lang['lang_3'], '', '', '<ul onmouseover="altStyle(this);">'.$selected.'</ul>');
	showsetting(lang("plugin/yinxingfei_zzza","x6"), 'filename', random(10), 'text', '', '', lang("plugin/yinxingfei_zzza","x7").' /data/zzza_backup/ '.lang("plugin/yinxingfei_zzza","x8"));
	showsubmit('backup', lang("plugin/yinxingfei_zzza","x9"));
	showformfooter();
	showtablefooter();
	showtableheader(lang("plugin/yinxingfei_zzza","x10"));
	if(!is_dir(DISCUZ_ROOT.'./data/zzza_backup/')) {
		@mkdir(DISCUZ_ROOT.'./data/zzza_backup/', 0777);
		@touch(DISCUZ_ROOT."./data/zzza_backup/index.htm");
	}
	$backup_dir = @dir(DISCUZ_ROOT.'./data/zzza_backup/');
	$flag = false;
	while(false !== ($entry = $backup_dir->read())) {
		$file = pathinfo($entry);
		if($file['extension'] == 'vbak' && $file['basename']) {
			showtablerow('', '', array(
				lang("plugin/yinxingfei_zzza","x11").''.$file['basename'],
				dgmdate(filemtime(DISCUZ_ROOT."./data/zzza_backup/{$file[basename]}"), 'u'),
				'<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=extend&caozuo=extend&file=sjbf&filename='.$file['basename'].'&restore=yes&formhash='.FORMHASH.'">'.lang("plugin/yinxingfei_zzza","x12").'</a>',
			));
			$flag = true;
		}
	}
	if(!$flag) showtablerow('', '', array('<font color="red">'.lang("plugin/yinxingfei_zzza","x13").'</font>'));
	showtablefooter();
	
	function zhdata ($zzza_db){
		$out_arr = array();
		foreach($zzza_db as $value){
			$query = DB::query('SELECT * FROM '.DB::table($value));
			while($data = DB::fetch($query)){
				$out_arr[$value][] = $data;
			}
		}
		return $out_arr;
	}
	function hfdata ($zzza_db,$zzza_tdb){
		DB::query('TRUNCATE TABLE '.DB::table($zzza_tdb));
		foreach ($zzza_db as $line){
			DB::insert($zzza_tdb, $line);
		}
	}
	function hfshezhi($data){
		$pluginid = DB::result_first("SELECT pluginid FROM ".DB::table('common_plugin')." WHERE identifier = 'yinxingfei_zzza'");
		foreach ($data as $line){
			DB::query("UPDATE ".DB::table('common_pluginvar')." SET value = '".$line['value']."' WHERE variable= '".$line['variable']."' AND pluginid = '".$pluginid."'", 'UNBUFFERED');
		}
	}
?>