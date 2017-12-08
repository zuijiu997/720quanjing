<?php echo 'NVbing5商业模板保护！购买正版模板请联系NVbing5客服QQ：2474414433';exit;?>
<!--{hook/global_footer_mobile}-->
<!--{eval $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);$clienturl = ''}-->
<!--{if strpos($useragent, 'iphone') !== false || strpos($useragent, 'ios') !== false}-->
<!--{eval $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=ios' : 'http://www.discuz.net/mobile.php?platform=ios';}-->
<!--{elseif strpos($useragent, 'android') !== false}-->
<!--{eval $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=android' : 'http://www.discuz.net/mobile.php?platform=android';}-->
<!--{elseif strpos($useragent, 'windows phone') !== false}-->
<!--{eval $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=windowsphone' : 'http://www.discuz.net/mobile.php?platform=windowsphone';}-->
<!--{/if}-->

<div id="mask" style="display:none;"></div>
<!--{if !$nofooter}-->
<div class="footer">
    <div>
		<a href="{$_G['setting']['mobile']['simpletypeurl'][0]}">{lang no_simplemobiletype}</a>  
		<a href="javascript:;" style="color:#D7D7D7;">{lang mobile2version}</a>  
		<a href="{$_G['setting']['mobile']['nomobileurl']}">{lang nomobiletype}</a> 
		<!--{if $clienturl}--><a href="$clienturl">{lang clientversion}</a><!--{/if}-->
    </div>
	<p>$_G['setting']['sitename']&nbsp;&nbsp;&nbsp;版权所有</p>
</div>
<!--{/if}-->

</body>
</html>
<!--{eval updatesession();}-->
<!--{if defined('IN_MOBILE')}-->
	<!--{eval output();}-->
<!--{else}-->
	<!--{eval output_preview();}-->
<!--{/if}-->
