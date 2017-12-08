<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if(file_exists($_G['style']['tpldir'].'/common/header.htm')){
	$tpl = fopen($_G['style']['tpldir'].'/common/header.htm','r');
	$tplcontent = fread ($tpl, filesize ($_G['style']['tpldir'].'/common/header.htm'));
}else{
	$tpl = fopen('./template/default/common/header.htm','r');
	$tplcontent = fread ($tpl, filesize ('./template/default/common/header.htm'));
}
fclose($tpl);

$tpl = fopen('source/plugin/showimg_dzx/template/header.htm','w');
fwrite($tpl,$tplcontent);
fclose($tpl);

$tplcontent = str_replace('<!--{subtemplate common/header_common}-->','<!--{subtemplate common/header_common}-->{template showimg_dzx:wf_css}',$tplcontent);
$tpl = fopen('source/plugin/showimg_dzx/template/wf_header.htm','w');
fwrite($tpl,$tplcontent);
fclose($tpl);
cpmsg(lang('plugin/showimg_dzx', 'mbtbwc'),'','succeed');
?>