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
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
loadcache('plugin');
$set = $_G['cache']['plugin']['yinxingfei_zzza'];
$yjfwsz = $set['zzza_yjfwsz'];
if($yjfwsz == 1){
	if(!submitcheck('emotsubmit')) {

			$emotechos = '';
			$query = DB::query("SELECT * FROM ".DB::table('yinxingfei_zzza_fw')." ORDER BY id");
			while($emot = DB::fetch($query)) {
				$isid = $emot[id] - 1 ;
				$isfw1 = DB::result_first("SELECT fwcs FROM ".DB::table('yinxingfei_zzza_fw')." WHERE id = '$isid'");
				$isfw = empty($isfw1) ? lang("plugin/yinxingfei_zzza","zuidijifen") : $isfw1;
				if(empty($isfw1)){
					$emotechos .= showtablerow('', array('class="td25"', 'class="td28"'), array(
						"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$emot[id]\">",
						"<input type=\"number\" class=\"txt\" size=\"2\" name=\"id[$emot[id]]\" value=\"$emot[id]\">",
						"{$isfw} : <input type=\"number\" class=\"txt\" size=\"5\" name=\"fwcs[$emot[id]]\" value=\"$emot[fwcs]\">",
						"<span>-</span>"
					), TRUE);
				}else{
					$emotechos .= showtablerow('', array('class="td25"', 'class="td28"'), array(
						"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$emot[id]\">",
						"<input type=\"number\" class=\"txt\" size=\"2\" name=\"id[$emot[id]]\" value=\"$emot[id]\">",
						"{$isfw} - <input type=\"number\" class=\"txt\" size=\"5\" name=\"fwcs[$emot[id]]\" value=\"$emot[fwcs]\">",
						"<input type=\"number\" class=\"txt\" size=\"10\" name=\"fwbfb[$emot[id]]\" value=\"$emot[fwbfb]\">".lang("plugin/yinxingfei_zzza","ren")
					), TRUE);
				}
				
			}

		echo <<<EOT
<script type="text/JavaScript">
	var rowtypedata = [
		[
			[1, '', 'td25'],
			[1, '<input type="number" class="txt" size="2" name="newid[]" value="0">', 'td28'],
			[1, '<input type="number" class="txt" size="15" name="newfwcs[]">'],
			[1, '<input type="number" class="txt" size="15" name="newfwbfb[]">'],
		],
	];
</script>
EOT;

		showformheader("plugins&operation=config&identifier=yinxingfei_zzza&pmod=yinxingfei_zzza_range&submit=1");
		showtips(lang("plugin/yinxingfei_zzza","shuoming1"));
		showtableheader('<strong>'.lang("plugin/yinxingfei_zzza","yw").'</strong>');
		showsubtitle(array( lang("plugin/yinxingfei_zzza","yw1"),lang("plugin/yinxingfei_zzza","yw2"), lang("plugin/yinxingfei_zzza","yw3"), lang("plugin/yinxingfei_zzza","glszcsaa")));
		echo $emotechos;
		echo '<tr><td></td><td colspan="4"><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.lang("plugin/yinxingfei_zzza","yw5").'</a></div></td></tr>';
		showsubmit('emotsubmit',lang("plugin/yinxingfei_zzza","jl7"));

		showtablefooter();
		showformfooter();

	} else {
		if($ids = dimplode($_GET['delete'])) {
			DB::query("DELETE FROM ".DB::table('yinxingfei_zzza_fw')." WHERE id IN ($ids)");
		}

		if(is_array($_GET['fwcs'])) {
			foreach($_GET['fwcs'] as $id => $val) {
				$_GET['fwbfb'][$id] = $_GET['fwbfb'][$id] > 100 ? 99 : $_GET['fwbfb'][$id];
				DB::update('yinxingfei_zzza_fw', array(
					'id' => $_GET['id'][$id],
					'fwcs' => $_GET['fwcs'][$id],
					'fwbfb' => $_GET['fwbfb'][$id],
				), "id='$id'");
			}
		}

		if(is_array($_GET['newfwcs'])) {
			foreach($_GET['newfwcs'] as $key => $value) {
				$newfwcs1 = trim($value);
				$newfwbfb1 = trim($_GET['newfwbfb'][$key]);
				if($newfwcs1 && $newfwbfb1) {
					$zzzanewid = $_GET['newid'][$key];
					$query = DB::query("SELECT id FROM ".DB::table('yinxingfei_zzza_fw')." WHERE id='$zzzanewid' LIMIT 1");
					$isid1 = $zzzanewid - 1 ;
					$isfw11 = DB::result_first("SELECT fwcs FROM ".DB::table('yinxingfei_zzza_fw')." WHERE id = '$isid1'");
					$isfw22 = empty($isfw11) ? 0 : $isfw11;
					if(DB::num_rows($query)) {
						cpmsg( lang("plugin/yinxingfei_zzza","jl11"), '', 'error');
					}
					if( $zzzanewid < 1)
					{
						cpmsg( $lang['jl12'], '', 'error');
					}elseif($newfwcs1 < $isfw22){
						cpmsg( lang("plugin/yinxingfei_zzza","jl22"), '', 'error');
					}else{
						$data = array(
							'id' => $zzzanewid,
							'fwcs' => $newfwcs1,
							'fwbfb' => $newfwbfb1,
						);
					}
					DB::insert('yinxingfei_zzza_fw', $data);
				} elseif(!$newfwcs1 || !$newfwbfb1) {
					cpmsg( lang("plugin/yinxingfei_zzza","jl10"), '', 'error');
				}
			}
		}
		cpmsg(lang("plugin/yinxingfei_zzza","jl8"),"action=plugins&operation=config&identifier=yinxingfei_zzza&pmod=yinxingfei_zzza_range", 'succeed');

	}
}else{
cpmsg( lang("plugin/yinxingfei_zzza","nofd"), '', 'error');
}	
?>