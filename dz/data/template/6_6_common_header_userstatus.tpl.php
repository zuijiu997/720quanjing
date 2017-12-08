<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); if($_G['uid']) { ?>
<style type="text/css">
.deanmessage .pipe{ display:none;}
.vwmy.qq{ padding-left:0; background-position:12px 12px; text-indent:32px;}
.deanbangding{}
.deanbangding a{ display:block; margin-bottom:15px!important; clear:both;}
</style>
<div class="deanloginin">
<div class="deanavartop"><a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>" title="<?php echo $_G['member']['username'];?>"><?php echo avatar($_G[uid],small);?></a></div>
    
    <div class="deantxs">
    	<a href="home.php?mod=space&amp;do=notice" id="myprompt"<?php if($_G['member']['newprompt']) { ?> class="new"<?php } ?> title="提醒">
                <?php if($_G['member']['newprompt']) { ?><em><?php echo $_G['member']['newprompt'];?></em><?php } ?></a><span id="myprompt_check"></span>
<?php if(empty($_G['cookie']['ignore_notice']) && ($_G['member']['newpm'] || $_G['member']['newprompt_num']['follower'] || $_G['member']['newprompt_num']['follow'] || $_G['member']['newprompt'])) { } ?>
    </div>
    <div class="deaninfo">
    	<div class="deanhove" title="操作"></div>
        <div class="clear"></div>
        <div class="deanmessage ">
        	<ul>
            	<?php if(check_diy_perm($topic)) { ?><li><?php echo $diynav;?></li><?php } ?>
                <li class="vwmy<?php if($_G['setting']['connect']['allow'] && $_G['member']['conisbind']) { ?> qq<?php } ?>"><a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>" target="_blank" title="访问我的空间"><?php echo $_G['member']['username'];?></a></li>
                <li><a href="home.php?mod=spacecp">设置</a></li>
                <li><a href="home.php?mod=space&amp;do=pm" id="pm_ntc"<?php if($_G['member']['newpm']) { ?> class="new"<?php } ?>>消息</a></li>
                <?php if($_G['setting']['taskon'] && !empty($_G['cookie']['taskdoing_'.$_G['uid']])) { ?><li><a href="home.php?mod=task&amp;item=doing" id="task_ntc" class="new">进行中的任务</a></li><?php } ?>
                <?php if(($_G['group']['allowmanagearticle'] || $_G['group']['allowpostarticle'] || $_G['group']['allowdiy'] || getstatus($_G['member']['allowadmincp'], 4) || getstatus($_G['member']['allowadmincp'], 6) || getstatus($_G['member']['allowadmincp'], 2) || getstatus($_G['member']['allowadmincp'], 3))) { ?>
<li><a href="portal.php?mod=portalcp"><?php if($_G['setting']['portalstatus'] ) { ?>门户管理<?php } else { ?>模块管理<?php } ?></a></li>
<?php } ?>
                <?php if($_G['uid'] && $_G['group']['radminid'] > 1) { ?><li><a href="forum.php?mod=modcp&amp;fid=<?php echo $_G['fid'];?>" target="_blank"><?php echo $_G['setting']['navs']['2']['navname'];?>管理</a></li><?php } ?>
                <?php if($_G['uid'] && $_G['adminid'] == 1 && $_G['setting']['cloud_status']) { ?><li><a href="admin.php?frames=yes&amp;action=cloud&amp;operation=applist" target="_blank">云平台</a></li><?php } ?>
                <?php if($_G['uid'] && getstatus($_G['member']['allowadmincp'], 1)) { ?><li><a href="admin.php" target="_blank">管理中心</a></li><?php } ?>
<li><a href="home.php?mod=spacecp&amp;ac=credit&amp;showcredit=1">积分: <?php echo $_G['member']['credits'];?></a></li>
                <li><a href="home.php?mod=spacecp&amp;ac=usergroup" ><?php echo $_G['group']['grouptitle'];?></a></li>
                
                <div class="deanbangding"><?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra1'])) echo $_G['setting']['pluginhooks']['global_usernav_extra1'];?></div>
                <div style="margin-bottom:5px!important;"><?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra2'])) echo $_G['setting']['pluginhooks']['global_usernav_extra2'];?></div>
                <div style="margin-bottom:5px!important;;"><?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra3'])) echo $_G['setting']['pluginhooks']['global_usernav_extra3'];?></div>
            </ul>
        </div>
    </div>
    <div class="deanexit"  title="退出登陆"><a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>"></a></div>
    <div class="clear"></div>
</div>

<?php } elseif(!empty($_G['cookie']['loginuser'])) { ?>
    <div class="deanmessage">
        <li><a id="loginuser" class="noborder"><?php echo dhtmlspecialchars($_G['cookie']['loginuser']); ?></a></li>
        <li><a href="member.php?mod=logging&amp;action=login" onclick="showWindow('login', this.href)">激活</a></li>
        <li><a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>">退出</a></li>
    </div>
<?php } elseif(!$_G['connectguest']) { ?>
    <div class="deanunlogin">
        <span>
            <div class="deankjdl">
                <dl>
                    <dd class="deanqq"><a href="connect.php?mod=login&amp;op=init&amp;referer=index.php&amp;statfrom=login_simple" target="_blank">QQ登录</a></dd>
                    <dd class="deanwxs"><a href="plugin.php?id=wechat:login" target="_blank">微信登录</a></dd>
                    <dd><a href="javascript:;" onclick="showWindow('login', 'member.php?mod=logging&action=login&viewlostpw=1')">忘记密码？</a></dd>
                </dl>
        	</div>
        </span>
        <ul>
            <li><a href="member.php?mod=<?php echo $_G['setting']['regname'];?>" target="_blank" class="deanzhuce">注册</a></li>
            <li><a href="member.php?mod=logging&amp;action=login" onClick="showWindow('login', this.href)" class="deandlu">登录</a></li>
            <div class="clear"></div>
        </ul>
        
        <div class="clear"></div>
    </div>
    <script type="text/javascript">
        jq(".deanunlogin span").hover(
            function(){
                jq(this).children(".deankjdl").show();
            },
            function(){
                jq(this).children(".deankjdl").hide();
                })
    </script>

<?php } else { ?>
<div id="um">
<div class="avt y"><?php echo avatar(0,small);?></div>
<p>
<strong class="vwmy qq"><?php echo $_G['member']['username'];?></strong>
<?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra1'])) echo $_G['setting']['pluginhooks']['global_usernav_extra1'];?>
<span class="pipe">|</span><a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>">退出</a>
</p>
<p>
<a href="home.php?mod=spacecp&amp;ac=credit&amp;showcredit=1">积分: 0</a>
<span class="pipe">|</span>用户组: <?php echo $_G['group']['grouptitle'];?>
</p>
</div>
<?php } ?>
<script type="text/javascript">
jq(".deanhove").hover(
function(){
jq(this).addClass("deanhoved");
jq(this).siblings(".deanmessage").show();
},
function(){
jq(this).removeClass("deanhoved");
jq(this).siblings(".deanmessage").hide();
})
jq(".deanmessage").hover(
function(){
jq(this).siblings(".deanhove").addClass("deanhoved");
jq(this).show();

},
function(){
jq(this).siblings(".deanhove").removeClass("deanhoved");
jq(this).hide();
})
</script>