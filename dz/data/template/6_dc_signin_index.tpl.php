<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<style>
.mytips{margin-left:10px;}
.mytips b{color:#FF0000}
</style>
<div class="mtm pbm bbs">
<div class="mytips">
<?php if(!$mysignin) { ?>
<font style="color:#FF0000;font-weight: 700;">您从未签到过，赶快签到吧!</font>
<?php } else { if($mysignin['dateline']<$todaystime) { ?><h1 class="mt">您今天还未签到~~</h1><?php } ?>
<p>尊敬的<b><?php echo $_G['username'];?></b> ，您累计已签到:  <b><?php echo $mysignin['days'];?></b> 天 ，连续签到:  <b><?php echo $mysignin['condays'];?></b> 天</p>
<p>您本月已累计签到:  <b><?php echo $mysignin['monthdays'];?></b> 天 ，本月连续签到:  <b><?php echo $mysignin['monthcondays'];?></b> 天</p>
<p>您上次签到时间: <b><?php echo dgmdate($mysignin['dateline']); ?></b></p>
<p>您目前获得的总奖励为: <?php echo $_G['setting']['extcredits'][$_G['cache']['plugin']['dc_signin']['extcredit']]['title'];?> <b><?php echo $mysignin['credit'];?></b> ，上次获得的奖励为: <?php echo $_G['setting']['extcredits'][$_G['cache']['plugin']['dc_signin']['extcredit']]['title'];?> <b><?php echo $mysignin['bcredit'];?></b> .</p>
<p>您目前的等级:  <b><?php echo $qdgroup[$mysignin['sgid']]['grouptitle'];?></b> ，您只需再签到 <b><?php echo $upgrade['dayslower']-$mysignin['days']; ?></b> 天就可以提升到下一个等级:  <b><?php echo $upgrade['grouptitle'];?></b> .</p>
<?php } ?>
</div>
</div> 
<div class="mtm" style="margin-left:10px;"><?php echo $_G['cache']['plugin']['dc_signin']['notice'];?></div>