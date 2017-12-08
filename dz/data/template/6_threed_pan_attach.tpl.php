<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); 

function show_pan_attach($ifbuy,$pan_url,$pan_srlname,$pan_srljiage,$allcount,$pan_type,$pan_srl,$pan_yuanjia) {
global $_G;
    $pan_kofen=$_G['cache']['plugin']['threed_pan']['thd_koufen'];
    $pan_panurl=$_G['cache']['plugin']['threed_pan']['thd_panurl'];
    $attachname=$_G['cache']['plugin']['threed_pan']['thd_name'];
    $pan_buyuser=unserialize($_G['cache']['plugin']['threed_pan']['thd_buyuser']);
    if(empty($pan_buyuser[0]))$pan_buyuser[0]=0;
    $pan_groupname=DB::result_first("SELECT grouptitle FROM ".DB::table('common_usergroup')." WHERE groupid=".$pan_buyuser[0]);
?><?php
$return = <<<EOF


EOF;
 if($pan_type==4) { 
$return .= <<<EOF

<link rel="stylesheet" type="text/css" href="source/plugin/threed_pan/template/downld.css">
<div class="threed_panbox" >  
<div class="panframe">
    	<div class="pan_left">
        
EOF;
 if($ifbuy ) { 
$return .= <<<EOF
   
<h4 style="width:720px;"><a href="{$pan_url}" target="_blank"><strong>{$pan_srlname}(点击下载原文件)</strong></a></h4>
      	
EOF;
 } else { 
$return .= <<<EOF

        <h4 style="width:720px;"><a href="javascript:" onclick="showWindow('paybox', '{$pan_url}')" rel="nofollow" style="text-decoration:none;"><strong>{$pan_srlname}(售价:{$pan_srljiage} {$_G['setting']['extcredits'][$_G['setting']['creditstransextra']['1']]['unit']}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra']['1']]['title']})</strong></a></h4>
        
EOF;
 } 
$return .= <<<EOF

<div class="thd_box" style=" width:710px; height:650px;overflow:hidden;">
<Iframe src="{$pan_srl}" width="730" height="880" scrolling="NO" style="margin:-170px 0px 0px -22px;">
                </iframe>
            </div>           
           
        </div>        
 	</div>   
</div>

EOF;
 } else { 
$return .= <<<EOF

<link rel="stylesheet" type="text/css" href="source/plugin/threed_pan/template/panattach.css">
<div class="attachbox">
  <div style="clear:both; width:670px;text-decoration:none;" class="tab_button"> 
    
EOF;
 if($ifbuy ) { 
$return .= <<<EOF

    <div class="button"> <a href="{$pan_url}"  target="_blank" rel="nofollow" style="text-decoration:none;"><img src="source/plugin/threed_pan/template/zip.gif" class="vm" alt="" border="0"><font style=" color:#fff !important;"> 请点击此处下载</font></a>
      <p class="top">请先注册会员后在进行下载</p>
      <p class="bottom">已注册会员，请先登录后下载</p>
    </div>
    
EOF;
 } else { 
$return .= <<<EOF

    <div class="button"> <a href="javascript:" onclick="showWindow('paybox', '{$pan_url}')" rel="nofollow" style="text-decoration:none;"><img src="source/plugin/threed_pan/template/zip.gif" class="vm" alt="" border="0"><font style=" color:#fff !important;">请点击此处下载</font></a>
      <p class="top">请先注册会员后在进行下载</p>
      <p class="bottom">已注册会员，请先登录后下载</p>
    </div>
    
EOF;
 } 
$return .= <<<EOF

    <div class="buttonright"> <span style="white-space: nowrap;"><em >{$attachname}</em>{$pan_srlname}&nbsp;</span><br />
    <em>下载次数:</em>{$allcount} &nbsp;&nbsp; 
EOF;
 if($pan_yuanjia) { 
$return .= <<<EOF
<em>状态:</em>
EOF;
 if($ifbuy ) { 
$return .= <<<EOF
已购或VIP
EOF;
 } else { 
$return .= <<<EOF
您未购买
EOF;
 } 
$return .= <<<EOF
&nbsp;&nbsp;<em>售价:</em>{$pan_srljiage} (原价:<del>{$pan_yuanjia}</del>){$_G['setting']['extcredits'][$_G['setting']['creditstransextra']['1']]['unit']}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra']['1']]['title']} 
EOF;
 } else { 
$return .= <<<EOF
<em >下载所需积分:</em>{$pan_kofen}&nbsp;{$_G['setting']['extcredits'][$_G['setting']['creditstransextra']['1']]['unit']}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra']['1']]['title']}
EOF;
 } 
$return .= <<<EOF
<br/>
      <em>下载权限:</em> <a target="_blank" href="/home.php?mod=spacecp&amp;ac=usergroup&amp;gid={$pan_buyuser['0']}"  rel="nofollow" class="xi2" style="text-decoration:none;"><font style="font-size:14px;" >{$pan_groupname}&nbsp;</font></a> {$pan_panurl} </div>
  </div>
  <br />
</div>

EOF;
 } 
$return .= <<<EOF


EOF;
?> <?php 
return $return;
}
?>