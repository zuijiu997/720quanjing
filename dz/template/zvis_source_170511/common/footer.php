<?php echo 'www.188yule.com,感谢大家的支持';exit;?>
	</div>
<!--{if empty($topic) || ($topic[usefooter])}-->
	<!--{eval $focusid = getfocus_rand($_G[basescript]);}-->
	<!--{if $focusid !== null}-->
		<!--{eval $focus = $_G['cache']['focus']['data'][$focusid];}-->
		<!--{eval $focusnum = count($_G['setting']['focus'][$_G[basescript]]);}-->
		<div class="focus" id="sitefocus">
			<div class="bm">
				<div class="bm_h cl">
					<a href="javascript:;" onclick="setcookie('nofocus_$_G[basescript]', 1, $_G['cache']['focus']['cookie']*3600);$('sitefocus').style.display='none'" class="y" title="{lang close}">{lang close}</a>
					<h2>
						<!--{if $_G['cache']['focus']['title']}-->{$_G['cache']['focus']['title']}<!--{else}-->{lang focus_hottopics}<!--{/if}-->
						<span id="focus_ctrl" class="fctrl"><img src="{IMGDIR}/pic_nv_prev.gif" alt="{lang footer_previous}" title="{lang footer_previous}" id="focusprev" class="cur1" onclick="showfocus('prev');" /> <em><span id="focuscur"></span>/$focusnum</em> <img src="{IMGDIR}/pic_nv_next.gif" alt="{lang footer_next}" title="{lang footer_next}" id="focusnext" class="cur1" onclick="showfocus('next')" /></span>
					</h2>
				</div>
				<div class="bm_c" id="focus_con">
				</div>
			</div>
		</div>
		<!--{eval $focusi = 0;}-->
		<!--{loop $_G['setting']['focus'][$_G[basescript]] $id}-->
				<div class="bm_c" style="display: none" id="focus_$focusi">
					<dl class="xld cl bbda">
						<dt><a href="{$_G['cache']['focus']['data'][$id]['url']}" class="xi2" target="_blank">$_G['cache']['focus']['data'][$id]['subject']</a></dt>
						<!--{if $_G['cache']['focus']['data'][$id][image]}-->
						<dd class="m"><a href="{$_G['cache']['focus']['data'][$id]['url']}" target="_blank"><img src="{$_G['cache']['focus']['data'][$id]['image']}" alt="$_G['cache']['focus']['data'][$id]['subject']" /></a></dd>
						<!--{/if}-->
						<dd>$_G['cache']['focus']['data'][$id]['summary']</dd>
					</dl>
					<p class="ptn cl"><a href="{$_G['cache']['focus']['data'][$id]['url']}" class="xi2 y" target="_blank">{lang focus_show} &raquo;</a></p>
				</div>
		<!--{eval $focusi ++;}-->
		<!--{/loop}-->
		<script type="text/javascript">
			var focusnum = $focusnum;
			if(focusnum < 2) {
				$('focus_ctrl').style.display = 'none';
			}
			if(!$('focuscur').innerHTML) {
				var randomnum = parseInt(Math.round(Math.random() * focusnum));
				$('focuscur').innerHTML = Math.max(1, randomnum);
			}
			showfocus();
			var focusautoshow = window.setInterval('showfocus(\'next\', 1);', 5000);
		</script>
	<!--{/if}-->
	<!--{if $_G['uid'] && $_G['member']['allowadmincp'] == 1 && $_G['setting']['showpatchnotice'] == 1}-->
		<div class="focus patch" id="patch_notice"></div>
	<!--{/if}-->

	<!--{ad/footerbanner/wp a_f/1}--><!--{ad/footerbanner/wp a_f/2}--><!--{ad/footerbanner/wp a_f/3}-->
	<!--{ad/float/a_fl/1}--><!--{ad/float/a_fr/2}-->
	<!--{ad/couplebanner/a_fl a_cb/1}--><!--{ad/couplebanner/a_fr a_cb/2}-->
	<!--{ad/cornerbanner/a_cn}-->

	<!--{hook/global_footer}-->
    
    <div class="deanfooter">
    	<div class="deanfttop">
        	<div class="w1180">
            	<div class="deanfttl">
                	<div class="deanftlogo"><img src="$_G['style'][styleimgdir]/ftlogo.png" /></div>
                    <div class="deanftguanzhu">
                    	<div class="deanftgzpic">
                        	<img src="$_G['style'][styleimgdir]/footer/erweima.png" />
                            <span>关注官方微信</span>
                        </div>
                        <div class="deanftgzingo">
                        	<p>微信号：dean_green</p>
                            <p>微博：blueFresh素材大全</p>
                            <p>QQ1群：45163589</p>
                            <p>QQ2群：54765476</p>
                        </div>
                        <div class="clear"></div>
                    </div>
                    
                </div>
                <div class="deanfttm">
                	<ul>
                    	<li>
                        	<h5>模板源码</h5>
                            <a href="#" target="_blank">WordPress模板</a>
                            <a href="#" target="_blank">Magento模板</a>
                            <a href="#" target="_blank">Joomla模板</a>
                            <a href="#" target="_blank">PrestaShop模板</a>
                            <a href="#" target="_blank">响应式模板</a>
                            <a href="#" target="_blank">PPT模板</a>
                        </li>
                        <li>
                        	<h5>素材种类</h5>
                            <a href="#" target="_blank">AE/PR模板</a>
                            <a href="#" target="_blank">CG模型</a>
                            <a href="#" target="_blank">PS笔刷/字体设计</a>
                            <a href="#" target="_blank">PPT模板</a>
                            <a href="#" target="_blank">高清背景图</a>
                            <a href="#" target="_blank">UI/PSD素材</a>
                        </li>
                        <li>
                        	<h5>关于我们</h5>
                            <a href="#" target="_blank">关于我们</a>
                            <a href="#" target="_blank">联系我们</a>
                            <a href="#" target="_blank">友情链接</a>
                            <a href="#" target="_blank">帮助中心</a>
                            <a href="#" target="_blank">权益保障</a>
                            <a href="#" target="_blank">下载须知</a>
                        </li>
                        <li>
                        	<h5>网站功能</h5>
                            <a href="#" target="_blank">视频教程</a>
                            <a href="#" target="_blank">作品展示</a>
                            <a href="#" target="_blank">上传下载</a>
                            <a href="#" target="_blank">成为VIP</a>
                            <a href="#" target="_blank">版权声明</a>
                            <a href="#" target="_blank">寻找灵感</a>
                        </li>
                        <div class="clear"></div>
                    </ul>
                </div>
                <div class="deanfttr">
                    <div class="deanfttels">
                    	<i></i>
                        <div class="deanfttelr">
                        	<h3>全国服务热线:</h3>
                            <p>400-123-456789</p>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="deantelbtms">（工作日：周一至周五 9:00-16:00）</div>
                    <div class="deanftitelsd">北京市朝阳区红军营南路19号集美家居后院楼2层</div>
                    <div class="deanftitelem">enquire@dean_green.com</div>
                    <div class="deankfqq"><a href="http://wpa.qq.com/msgrd?v=3&uin=1691000615&site=qq&amp;menu=yes" target="_blank">QQ在线客服</a></div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="deanftbottom">
                <p class="deanpp">
                    
                    <!--{loop $_G['setting']['footernavs'] $nav}--><!--{if $nav['available'] && ($nav['type'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1)) ||
                            !$nav['type'] && ($nav['id'] == 'stat' && $_G['group']['allowstatdata'] || $nav['id'] == 'report' && $_G['uid'] || $nav['id'] == 'archiver' || $nav['id'] == 'mobile' || $nav['id'] == 'darkroom'))}-->$nav[code]<span class="pipe">-</span><!--{/if}--><!--{/loop}-->
                            <a href="$_G['setting']['siteurl']" target="_blank">$_G['setting']['sitename']</a>
                    
                    <!--{hook/global_footerlink}-->
                    <!--{if $_G['setting']['statcode']}-->$_G['setting']['statcode']<!--{/if}-->
                </p>
                <p>
                    Powered by <a href="http://www.discuz.net" target="_blank">Discuz!</a> <em>$_G['setting']['version']</em><!--{if !empty($_G['setting']['boardlicensed'])}--> <a href="http://license.comsenz.com/?pid=1&host=$_SERVER[HTTP_HOST]" target="_blank">Licensed</a><!--{/if}-->&copy; 2001-2013 <a href="http://www.comsenz.com" target="_blank">Comsenz Inc.</a>&nbsp;&nbsp;<!--{if $_G['setting']['icp']}--><a href="http://www.miitbeian.gov.cn/" target="_blank">$_G['setting']['icp']</a><!--{/if}-->
                </p>
                <div class="deanbutNav">
                  <a title="工商网监" href="#" target="_blank"><img src="$_G['style'][styleimgdir]/footer/botpic_r1_c4.png"></a>
                  <a title="安全联盟实名认证" href="#" target="_blank"><img src="$_G['style'][styleimgdir]/footer/botpic_r1_c1.jpg"></a>
                  <a href="#" target="_blank">
                  <img src="$_G['style'][styleimgdir]/footer/botpic_r1_c5.png" width="100" alt="安全联盟认证"/>
                  </a>
                  <a title="财付通" href="#" target="_blank"><img src="$_G['style'][styleimgdir]/footer/botpic_r1_c2.jpg"></a>
                  <a title="支付宝" href="#" target="_blank"><img src="$_G['style'][styleimgdir]/footer/botpic_r1_c3.jpg"></a>
                </div>
            </div>
    </div>
    
	<div id="ft" style=" display:none;">
		
		
		<!--{eval updatesession();}-->
		<!--{if $_G['uid'] && $_G['group']['allowinvisible']}-->
			<script type="text/javascript">
			var invisiblestatus = '<!--{if $_G['session']['invisible']}-->{lang login_invisible_mode}<!--{else}-->{lang login_normal_mode}<!--{/if}-->';
			var loginstatusobj = $('loginstatusid');
			if(loginstatusobj != undefined && loginstatusobj != null) loginstatusobj.innerHTML = invisiblestatus;
			</script>
		<!--{/if}-->
	</div>
<!--{/if}-->

<!--{if !$_G['setting']['bbclosed']}-->
	<!--{if $_G[uid] && !isset($_G['cookie']['checkpm'])}-->
	<script type="text/javascript" src="home.php?mod=spacecp&ac=pm&op=checknewpm&rand=$_G[timestamp]"></script>
	<!--{/if}-->

	<!--{if $_G[uid] && helper_access::check_module('follow') && !isset($_G['cookie']['checkfollow'])}-->
	<script type="text/javascript" src="home.php?mod=spacecp&ac=follow&op=checkfeed&rand=$_G[timestamp]"></script>
	<!--{/if}-->

	<!--{if !isset($_G['cookie']['sendmail'])}-->
	<script type="text/javascript" src="home.php?mod=misc&ac=sendmail&rand=$_G[timestamp]"></script>
	<!--{/if}-->

	<!--{if $_G[uid] && $_G['member']['allowadmincp'] == 1 && !isset($_G['cookie']['checkpatch'])}-->
	<script type="text/javascript" src="misc.php?mod=patch&action=checkpatch&rand=$_G[timestamp]"></script>
	<!--{/if}-->

<!--{/if}-->

<!--{if $_GET['diy'] == 'yes'}-->
	<!--{if check_diy_perm($topic) && (empty($do) || $do != 'index')}-->
		<script type="text/javascript" src="{$_G[setting][jspath]}common_diy.js?{VERHASH}"></script>
		<script type="text/javascript" src="{$_G[setting][jspath]}portal_diy{if !check_diy_perm($topic, 'layout')}_data{/if}.js?{VERHASH}"></script>
	<!--{/if}-->
	<!--{if $space['self'] && CURMODULE == 'space' && $do == 'index'}-->
		<script type="text/javascript" src="{$_G[setting][jspath]}common_diy.js?{VERHASH}"></script>
		<script type="text/javascript" src="{$_G[setting][jspath]}space_diy.js?{VERHASH}"></script>
	<!--{/if}-->
<!--{/if}-->
<!--{if $_G['uid'] && $_G['member']['allowadmincp'] == 1 && $_G['setting']['showpatchnotice'] == 1}-->
	<script type="text/javascript">patchNotice();</script>
<!--{/if}-->
<!--{if $_G['uid'] && $_G['member']['allowadmincp'] == 1 && empty($_G['cookie']['pluginnotice'])}-->
	<div class="focus plugin" id="plugin_notice"></div>
	<script type="text/javascript">pluginNotice();</script>
<!--{/if}-->
<!--{if !$_G['setting']['bbclosed'] && $_G['setting']['disableipnotice'] != 1 && $_G['uid'] && !empty($_G['cookie']['lip'])}-->
	<div class="focus plugin" id="ip_notice"></div>
	<script type="text/javascript">ipNotice();</script>
<!--{/if}-->
<!--{if $_G['member']['newprompt'] && (empty($_G['cookie']['promptstate_'.$_G[uid]]) || $_G['cookie']['promptstate_'.$_G[uid]] != $_G['member']['newprompt']) && $_GET['do'] != 'notice'}-->
	<script type="text/javascript">noticeTitle();</script>
<!--{/if}-->

<!--{if ($_G[member][newpm] || $_G[member][newprompt]) && empty($_G['cookie']['ignore_notice'])}-->
	<script type="text/javascript" src="{$_G[setting][jspath]}html5notification.js?{VERHASH}"></script>
	<script type="text/javascript">
	var h5n = new Html5notification();
	if(h5n.issupport()) {
		<!--{if $_G[member][newpm] && $_GET[do] != 'pm'}-->
		h5n.shownotification('pm', '$_G[siteurl]home.php?mod=space&do=pm', '<!--{avatar($_G[uid],small,true)}-->', '{lang newpm_subject}', '{lang newpm_notice_info}');
		<!--{/if}-->
		<!--{if $_G[member][newprompt] && $_GET[do] != 'notice'}-->
				<!--{loop $_G['member']['category_num'] $key $val}-->
					<!--{eval $noticetitle = lang('template', 'notice_'.$key);}-->
					h5n.shownotification('notice_$key', '$_G[siteurl]home.php?mod=space&do=notice&view=$key', '<!--{avatar($_G[uid],small,true)}-->', '$noticetitle ($val)', '{lang newnotice_notice_info}');
				<!--{/loop}-->
		<!--{/if}-->
	}
	</script>
<!--{/if}-->

<!--{eval userappprompt();}-->
<!--{if $_G['basescript'] != 'userapp'}-->
<div id="scrolltop" style="display:none;">
	<!--{if $_G[fid] && $_G['mod'] == 'viewthread'}-->
	<!--{/if}-->
	<span hidefocus="true"><a title="{lang scrolltop}" onclick="window.scrollTo('0','0')" id="scrolltopa" ><b>{lang scrolltop}</b></a></span>
	<!--{if $_G[fid]}-->
	<span>
		<!--{if $_G['mod'] == 'viewthread'}-->
		<a href="forum.php?mod=forumdisplay&fid=$_G[fid]" hidefocus="true" class="returnlist" title="{lang return_list}"><b>{lang return_list}</b></a>
		<!--{else}-->
		<a href="forum.php" hidefocus="true" class="returnboard" title="{lang return_forum}"><b>{lang return_forum}</b></a>
		<!--{/if}-->
	</span>
	<!--{/if}-->
</div>


<script type="text/javascript">_attachEvent(window, 'scroll', function () { showTopLink(); });checkBlind();</script>
<!--{/if}-->
<!--{if isset($_G['makehtml'])}-->
	<script type="text/javascript" src="{$_G[setting][jspath]}html2dynamic.js?{VERHASH}"></script>
	<script type="text/javascript">
		var html_lostmodify = {TIMESTAMP};
		htmlGetUserStatus();
		<!--{if isset($_G['htmlcheckupdate'])}-->
		htmlCheckUpdate();
		<!--{/if}-->
	</script>
<!--{/if}-->
<!--{eval output();}-->

</body>
</html>
